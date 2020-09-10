<?php
namespace frontend\controllers;

use common\models\BcPlacesPrice;
use common\models\BcPlacesSellPrice;
use common\models\BcValutes;
use common\models\Taxes;
use common\models\ViewsCounter;
use Yii;
use yii\web\Controller;
use common\models\Services;
use common\models\BcItems;
use common\models\SeoCatalogUrls;
use common\models\SeoCatalogUrlsCities;
use common\models\SeoCatalogUrlsBcclasses;
use common\models\GeoCities;
use common\models\GeoDistricts;
use common\models\GeoSubways;
use common\models\BcClasses;
use common\models\BcStatuses;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\models\BcItemsSearch;
use kartik\mpdf\Pdf;
use frontend\models\OrderForm;
use common\models\User;

/**
 * Page controller
 */
class PageController extends FrontendController
{

    public function actionServices($slug)
    {
        $model = Services::find()->joinWith(['slug'])->where(['slug' => $slug])->multilingual()->one();
        return $this->render('service', [
            'model' => $model,
        ]);
    }

    public function officeData($slug, $target)
    {
        $data = [];

        $targetId = $target == 'sell' ? 2 : 1;

        if ($target == 'sell') {
            $query = BcPlacesSell::find()->joinWith(['slug']);
            $placeModel = 'bc_places_sell';
        } else {
            $query = BcPlaces::find()->joinWith(['slug']);
            $placeModel = 'bc_places';
        }

        $model = $query->where(['slug' => $slug])->one();
        //debug($model->bcitem); die();
        //$item = $model->no_bc === 1 ? $model->office : $model->bcitem; //bc or office for this place
        //debug($item); die();

        $seo = SeoCatalogUrls::find()->where(['id' => 88])->multilingual()->one();
        $mainRent = trim($seo->main_rent_link_href, '/');
        $mainSell = trim($seo->main_sell_link_href, '/');
        $item = $model->bcitem;
        if ($item->class) {
            $class = $item->class->id;
            $city = $item->city->id;
            $classes = SeoCatalogUrlsBcclasses::find()->select('catalog_url_id')->where(['bc_class_id' => $class])->asArray()->all();
            $classes = ArrayHelper::getColumn($classes, 'catalog_url_id');
            $cities = SeoCatalogUrlsCities::find()->select('catalog_url_id')->where(['city_id' => $city])->andWhere(['in', 'catalog_url_id', $classes])->asArray()->all();
            $cities = ArrayHelper::getColumn($cities, 'catalog_url_id');
            $seoClass = SeoCatalogUrls::find()->where(['target' => $targetId])->andWhere(['in', 'id', $cities])->multilingual()->one();
        }

        $viewCounter = ViewsCounter::find()->where(['item_id' => $model->id])->andWhere(['model' => $placeModel])->one();
        if (!(count($viewCounter) > 0)) {
            $viewCounter = new ViewsCounter();
            $viewCounter->item_id = $model->id;
            $viewCounter->model = $placeModel;
            $viewCounter->count_view = 0;
            $viewCounter->save();
        }
        $viewCounter->processCountViewItem();

        $broker = $item->brokers ? $item->brokers[0]->userInfo : User::findOne(8);

        $data['model'] = $model;
        $data['targetId'] = $targetId;
        $data['seoClass'] = $seoClass;
        $data['mainRent'] = $mainRent;
        $data['mainSell'] = $mainSell;
        $data['item'] = $item;
        $data['broker'] = $broker;
        return $data;
    }

    public function actionBc_places($slug)
    {
        $data = $this->officeData($slug, 'rent');
        $priceDatas = $this->getPriceDatas();
        $rates = $priceDatas[0];
        $taxes = $priceDatas[1];
        $this->result = 'offices';
        return $this->render('place', [
            'model' => $data['model'],
            'target' => $data['targetId'],
            'seoClass' => $data['seoClass'],
            'mainRent' => $data['mainRent'],
            'mainSell' => $data['mainSell'],
            'item' => $data['item'],
            'broker' => $data['broker'],
            'rates' => $rates,
            'taxes' => $taxes
        ]);
    }

    public function actionBc_places_sell($slug)
    {
        $data = $this->officeData($slug, 'sell');
        $priceDatas = $this->getPriceDatas();
        $rates = $priceDatas[0];
        $taxes = $priceDatas[1];

        $this->result = 'offices';
        return $this->render('place', [
            'model' => $data['model'],
            'target' => $data['targetId'],
            'seoClass' => $data['seoClass'],
            'mainRent' => $data['mainRent'],
            'mainSell' => $data['mainSell'],
            'item' => $data['item'],
            'broker' => $data['broker'],
            'rates' => $rates,
            'taxes' => $taxes
        ]);
    }

    //страница бизнес-центра
    public function actionBc_items($slug)
    {
        $target = Yii::$app->request->get('target');
        $targetId = $target == 'sell' ? 2 : 1;

        $query = BcItems::find()->joinWith(['slug']);
        if ($targetId == 2) {
            $query->with('subways.subwayDetails', 'characteristics.characteristic', 'brokers', 'owners', 'placesSell.prices');
        } else {
            $query->with('subways.subwayDetails', 'characteristics.characteristic', 'brokers', 'owners', 'places.prices');
        }

        $model = $query->where(['slug' => $slug])->one();

        $seo = SeoCatalogUrls::find()->where(['id' => 88])->multilingual()->one();
        $mainRent = trim($seo->main_rent_link_href, '/');
        $mainSell = trim($seo->main_sell_link_href, '/');
        if ($model->class) {
            $class = $model->class->id;
            $city = $model->city->id;
            $classes = SeoCatalogUrlsBcclasses::find()->select('catalog_url_id')->where(['bc_class_id' => $class])->asArray()->all();
            $classes = ArrayHelper::getColumn($classes, 'catalog_url_id');
            $cities = SeoCatalogUrlsCities::find()->select('catalog_url_id')->where(['city_id' => $city])->andWhere(['in', 'catalog_url_id', $classes])->asArray()->all();
            $cities = ArrayHelper::getColumn($cities, 'catalog_url_id');
            $seoClass = SeoCatalogUrls::find()->where(['target' => $targetId])->andWhere(['in', 'id', $cities])->multilingual()->one();
        }

        $viewCounter = ViewsCounter::find()->where(['item_id' => $model->id])->andWhere(['model' => 'bc_items'])->one();
        if (!(count($viewCounter) > 0)) {
            $viewCounter = new ViewsCounter();
            $viewCounter->item_id = $model->id;
            $viewCounter->model = 'bc_items';
            $viewCounter->count_view = 0;
            $viewCounter->save();
        }
        $viewCounter->processCountViewItem();

        $order = new OrderForm(); //User::findOne($id)
        $broker = $model->brokers ? $model->brokers[0]->userInfo : User::findOne(8);
        $order->toEmail = $broker->email;
        $order->subject = 'subject';

        $priceDatas = $this->getPriceDatas();
        $rates = $priceDatas[0];
        $taxes = $priceDatas[1];

        return $this->render('item', [
            'model' => $model,
            'target' => $targetId,
            'seoClass' => $seoClass,
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
            'order' => $order,
            'broker' => $broker,
            'rates' => $rates,
            'taxes' => $taxes
        ]);
    }

    protected function getPriceDatas()
    {
        $rates = BcValutes::find()->select(['id', 'rate'])->asArray()->all();
        $rates = ArrayHelper::getColumn(ArrayHelper::index($rates, 'id'), 'rate');
        $taxes = Taxes::find()->select(['id', 'value'])->where(['id' => 1])->orWhere(['id' => 4])->asArray()->all();
        $taxes = ArrayHelper::getColumn(ArrayHelper::index($taxes, 'id'), 'value');
        return [$rates, $taxes];
    }

    public function actionFavorite()
    {
        //$model = \Yii::$app->wishlist->getUserWishList();
        $model = \Yii::$app->wishlist->getItemsForPage();
        $targetUrls = \Yii::$app->wishlist->getTargetUrls();
        \yii\helpers\Url::remember();

        return $this->render('favorite', [
            'model' => $model,
            'targetUrls' => $targetUrls
        ]);
    }

    public function actionRemoveFavorites()
    {
        if (Yii::$app->request->post() && \Yii::$app->wishlist->removeAll()) {
            $link = '/' . Yii::$app->request->post('link');
            return $this->redirect($link);
        } else {
            Yii::$app->session->setFlash('error', "Ошибка при удалении");
            return $this->goBack();
        }
    }

    //записаться на просмотр
    public function actionOrder($id)
    {
        $model = new OrderForm();
        $broker = User::findOne($id);
        $model->toEmail = $broker->email;
        $model->subject = 'subject';//'Заявка на просмотр для '.$broker->name. ' '.$broker->surname;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendOrder()) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->renderAjax('order-modal', [
                'model' => $model,
                'user' => $broker
            ]);
        }
    }

    public function actionPdf($id, $target)
    {
        $model = BcItems::find()->where(['id' => $id])->one();
        $currentLanguage = Yii::$app->language;
        $title = getDefaultTranslate('title', $currentLanguage, $model, true);
        /*return $this->renderPartial('_item-pdf', [
            'model' => $model,
            'target' => $target,
        ]);*/


        $content = $this->renderPartial('_item-pdf', [
            'model' => $model,
            'target' => $target,
        ]);

        $pdf = new Pdf([
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@frontend/web/css/pdf.css',
            'methods' => [
                'SetTitle' => $title,
                'SetHeader' => [$title . '||' . date('d-m-Y')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionShowPlace($id, $target)
    {
        if ($target == 1) {
            $model = BcPlaces::find()->where(['id' => $id])->one();
        } else {
            $model = BcPlacesSell::find()->where(['id' => $id])->one();
        }

        return $this->renderAjax('show-place', [
            'model' => $model,
        ]);
    }

    public function getFilter($seo, $params)
    {
        //debug($params);
        $currentLanguage = Yii::$app->language;
        $searchParams = [];
        $searchParams['result'] = !empty($params['result']) ? $params['result'] : 'offices';
        //$searchParams['page'] = !empty($params['page']) ? $params['page'] : null;
        $searchParams['lang'] = $currentLanguage;
        $searchParams['m2min'] = '';
        $searchParams['m2max'] = '';
        $searchParams['sort'] = !empty($params['sort']) ? $params['sort'] : '';
        $searchParams['city'] = $seo->city->city_id !== 0 ? $seo->city->city_id : '';
        $searchParams['country'] = $seo->country->country_id !== 0 ? $seo->country->country_id : '';
        $searchParams['target'] = $seo->target;

        $searchParams['currency'] = 1;
        $searchParams['type'] = 1;
        $searchParams['pricemin'] = '';
        $searchParams['pricemax'] = '';

        $searchParams['streetId'] = !empty($params['streetId']) ? $params['streetId'] : null;
        //debug($searchParams);


        if (empty($params)) {
            if ($seo->m2) {
                $m2 = explode('-', $seo->m2);
                if (count($m2) == 2) {
                    $searchParams['m2min'] = $m2[0];
                    $searchParams['m2max'] = $m2[1];
                } else {
                    $searchParams['m2min'] = $m2[0];
                    $searchParams['m2max'] = '';
                }
            }
            $searchParams['commission'] = $seo->bc_commission == 1 ? 0 : '';
            $searchParams['classes'] = ArrayHelper::getColumn($seo->classes, 'bc_class_id');
            $searchParams['districts'] = $seo->districts ? ArrayHelper::getColumn($seo->districts, 'district_id') : '';
            $searchParams['price'] = $seo->price;
            $searchParams['walk_dist'] = '';
            $searchParams['subways'] = '';
            $searchParams['statuses'] = [];
        } else {

            $params['m2min'] = isset($params['m2min']) ? $params['m2min'] : '';
            $params['m2max'] = isset($params['m2max']) ? $params['m2max'] : '';
            $params['districts'] = isset($params['districts']) ? $params['districts'] : [];
            $params['classes'] = isset($params['classes']) ? $params['classes'] : [];
            $params['statuses'] = isset($params['statuses']) ? $params['statuses'] : [];
            $params['comission'] = isset($params['comission']) ? $params['comission'] : '';
            $params['walk_dist'] = isset($params['walk_dist']) ? $params['walk_dist'] : '';
            $params['subways'] = isset($params['subways']) ? $params['subways'] : '';
            $params['user'] = isset($params['user']) ? $params['user'] : '';
            $params['visibles'] = isset($params['visibles']) ? $params['visibles'] : [];

            $searchParams['m2min'] = $params['m2min'];
            $searchParams['m2max'] = $params['m2max'];
            $searchParams['districts'] = count($params['districts']) > 0 ? $params['districts'] : '';
            $searchParams['classes'] = count($params['classes']) > 0 ? $params['classes'] : '';
            $searchParams['statuses'] = count($params['statuses']) > 0 ? $params['statuses'] : '';
            $searchParams['commission'] = $params['comission'] == 'on' ? 0 : '';
            $searchParams['walk_dist'] = !empty($params['walk_dist']) ? $params['walk_dist'] : '';
            //debug($params); die();
            $searchParams['subways'] = !empty($params['subways']) ? $params['subways'] : '';
            $searchParams['user'] = !empty($params['user']) ? $params['user'] : '';
            $searchParams['visibles'] = !empty($params['visibles']) ? $params['visibles'] : [];

            $searchParams['pricemin'] = !empty($params['pricemin']) ? $params['pricemin'] : '';
            $searchParams['pricemax'] = !empty($params['pricemax']) ? $params['pricemax'] : '';
            $searchParams['currency'] = !empty($params['currency']) ? $params['currency'] : 1;
            $searchParams['type'] = !empty($params['type']) ? $params['type'] : 1;
        }
        //debug($searchParams); die();
        return $searchParams;
    }

    //тестирование выдачи по условиям фильтров
    public function actionTestitems()
    {
        $whereCondition = [];
        $whereCondition['result'] = 'bc'; //'offices'; //
        //$whereCondition['target'] = 1;
        //$whereCondition['country'] = 1;
        // $whereCondition['city'] = 1;
        //$whereCondition['sort'] = 'price_desc';
        //$whereCondition['lang'] = 'ua';
        //$whereCondition['m2min'] = 100;
        //$whereCondition['m2max'] = 150;
        //$whereCondition['currency'] = 2;
        //$whereCondition['pricemin'] = 10;
        //$whereCondition['pricemax'] = 20;
        //$whereCondition['user'] = 259;
        //$whereCondition['subways'] = 305;
        //$whereCondition['walk_dist'] = 1500;
        //$whereCondition['classes'] = [1, 2];
        //$whereCondition['districts'] = [45, 46];
        //$whereCondition['visibles'] = [31792, 31627, 32171];
        $searchModel = new BcItemsSearch();
        $result = $searchModel->seoSearchFromView($whereCondition);

        return $this->render('test-items', [
            'test' => $result
        ]);
    }

    public function actionPopupCards()
    {
        if (Yii::$app->request->isPjax && Yii::$app->request->post('markerId')) {
            $params['markerId'] = Yii::$app->request->post('markerId');
            $params['result'] = Yii::$app->request->post('result');
            $params['target'] = Yii::$app->request->post('target');
            $params['currency'] = Yii::$app->request->post('currency');
            $params['lang'] = Yii::$app->language;
            //$currency = 2;
            //$markerId, $result, $target
            $searchModel = new BcItemsSearch();
            $searchResult = $searchModel->getPopupCards($params);
            //debug($params); die();
            //debug($searchResult); die();
            $priceDatas = $this->getPriceDatas();
            $rates = $priceDatas[0];
            $taxes = $priceDatas[1];
            return $this->renderPartial('popup-cards', [
                'searchResult' => $searchResult,
                'params' => $params,
                'rates' => $rates,
                'taxes' => $taxes,
                //'currency' => $params['currency']
            ]);
        }
        return false;
    }

    public function actionTestPopup()
    {
        $params['markerId'] = 32268;
        $params['result'] = 'bc'; //'offices';//
        $params['target'] = 1;
        $params['lang'] = Yii::$app->language;
        $params['currency'] = 1;
        //$markerId, $result, $target
        $searchModel = new BcItemsSearch();
        $searchResult = $searchModel->getPopupCards($params);
        //debug($params); die();
        //debug($searchResult); die();
        $priceDatas = $this->getPriceDatas();
        $rates = $priceDatas[0];
        $taxes = $priceDatas[1];
        return $this->render('popup-cards', [
            'searchResult' => $searchResult,
            'params' => $params,
            'rates' => $rates,
            'taxes' => $taxes,
            //'currency' => $params['currency']
        ]);
    }

    //страница выдачи каталога
    public function actionSeo_catalog_urls($slug)
    {
        $seo = SeoCatalogUrls::find()
            ->joinWith(['slug'])
            ->where(['slug' => $slug])
            ->multilingual()
            ->one();
        //debug($seo); die();

        if ($seo->city->city_id !== 0) {
            $city = $seo->city->city;
            $city_id = $city->id;
        } else {
            $city = 0;
            $city_id = 0;
        }

        if ($city !== 0) {
            $center = [$city->lng, $city->lat];
            $zoom = $city->zoom;
        } else {
            $center = [30.52340000, 50.45010000]; //Ukraine
            $zoom = 6;
        }

        $paramsPost = [];
        $paramsGet = [];
        $params = [];

        if (Yii::$app->request->post('filter')) $paramsPost = Yii::$app->request->post('filter');
        if (Yii::$app->request->get('filter')) $paramsGet = Yii::$app->request->get('filter');
        $params = ArrayHelper::merge($paramsPost, $paramsGet);

        $session = Yii::$app->session;

        if (!empty(Yii::$app->request->get('page'))) {
            if (!Yii::$app->request->post('visibles') && $session->has('visibles')) $params['visibles'] = $session->get('visibles');
            if (!Yii::$app->request->post('center') && $session->has('center')) $center = $session->get('center');
            if (!Yii::$app->request->post('zoom') && $session->has('zoom')) $zoom = $session->get('zoom');
            if (!Yii::$app->request->post('result') && $session->has('result')) $zoom = $session->get('result');
        } else {
            if ($session->has('visibles')) $session->remove('visibles');
            if ($session->has('center')) $session->remove('center');
            if ($session->has('zoom')) $session->remove('zoom');
            if ($session->has('result')) $session->remove('result');
        }

        if (Yii::$app->request->isPjax) {
            if (Yii::$app->request->post('visibles') && count(Yii::$app->request->post('visibles')) > 0) {
                $params['visibles'] = Yii::$app->request->post('visibles');
                $session->set('visibles', $params['visibles']);
            }
            if (Yii::$app->request->post('center') && Yii::$app->request->post('center') != 0) {
                $center = Yii::$app->request->post('center');
                $session->set('center', $center);
            }
            if (Yii::$app->request->post('zoom') && Yii::$app->request->post('zoom') != 0) {
                $zoom = Yii::$app->request->post('zoom');
                $session->set('zoom', $zoom);
            }
            if (Yii::$app->request->post('result') && !empty(Yii::$app->request->post('result'))) {
                $params['result'] = Yii::$app->request->post('result');
                $session->set('result', $params['result']);
            }

        }

        $whereCondition = $this->getFilter($seo, $params);
        $searchModel = new BcItemsSearch();
        $result = $searchModel->seoSearchFromView($whereCondition);

        $this->result = !empty($params) && !empty($params['result']) ? $params['result'] : 'bc';

        $targetLinks = SeoCatalogUrls::find()->where(['id' => 88])->one();
        $mainRent = trim($targetLinks->main_rent_link_href, '/');
        $mainSell = trim($targetLinks->main_sell_link_href, '/');
        $currency = $whereCondition['currency'];

        $priceDatas = $this->getPriceDatas();
        $rates = $priceDatas[0];
        $taxes = $priceDatas[1];


        if (!$session->has('center') && $result['center']) {
            $center = $result['center'];
        }


        return $this->render('items', [
            'seo' => $seo,
            'city' => $city,
            'items' => $result['allForPage'],
            'countPlaces' => $result['count_ofices'],
            'pages' => $result['pages'],
            'markers' => $result['markers'],
            'center' => json_encode($center),
            'zoom' => $zoom,
            'filters' => $this->getDataForFilter($city_id),
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
            'params' => $params,
            'conditions' => $whereCondition,
            'pricesChart' => $this->getPlacesForPriceChart($result['pricesForChart'], $seo->target),
            'countValM2' => $this->getPlacesForM2Chart($result['m2ForChart'], $seo->target),
            'countValDist' => $this->getPlacesForSubwayChart($result['distancesForChart']),
            'rates' => $rates,
            'currency' => $currency,
            'taxes' => $taxes,
        ]);
    }

    public function actionBars()
    {
        if (Yii::$app->request->isPjax) {
            $bars = unserialize(Yii::$app->request->post('bars')[0]);
            $currency = Yii::$app->request->post('currency');
            $rate = BcValutes::getRate($currency);
            return $this->renderAjax('_partial/_bars', [
                'bars' => $bars,
                'rate' => $rate['rate'],
                'currency' => $currency,
            ]);
        }
        return false;
    }

    protected function getDataForFilter($city)
    {
        //$city=5;
        $filters = [];
        $filters['subways'] = [];
        $filters['branches'] = [];

        $districts = GeoDistricts::find();
        $subways = GeoSubways::find();
        if ($city != 0) {
            $where = ['city_id' => $city];
        }
        if (!empty($where)) {
            $districts->where($where);
            $subways->where($where)->orderBy('branch_id, sort_order');
        }
        //$filters['subways'] = $subways = $subways->all();
        $subways = $subways->all();
        if (!empty($subways)) {
            foreach ($subways as $sub) {
                switch ($sub->branch_id) {
                    case 1:
                        $filters['subways'][1][] = $sub;
                        $branches[1] = 1;
                        break;
                    case 2:
                        $filters['subways'][2][] = $sub;
                        $branches[2] = 2;
                        break;
                    case 3:
                        $filters['subways'][3][] = $sub;
                        $branches[3] = 3;
                        break;
                }
            }
            sort($branches);
            $filters['branches'] = $branches;
        }

        $filters['district'] = $districts->all();

        $filters['classes'] = BcClasses::find()->all();
        $filters['statuses'] = BcStatuses::find()->all();

        return $filters;
    }

    protected function getPlacesForSubwayChart($distArr)
    {
        $parts = Yii::$app->settings->partsDist;
        $maxValue = Yii::$app->settings->maxMdist;
        $countVal = [];
        $countVal['count'] = [];
        $countVal['max'] = 0;
        $countVal['min'] = 0;
        if (count($distArr) > 0) {
            $distArrLimited = array_filter($distArr, function ($k) use ($maxValue) {
                return $k <= $maxValue;
            });

            $max = max($distArr);
            $min = min($distArr);
            $delta = round($maxValue / $parts);

            $countVal['count'] = $this->getRanges($distArrLimited, $delta, $parts);
            $countVal['maxVal'] = $maxValue;
            $countVal['max'] = $max;
            $countVal['min'] = $min;
        }
        //debug($countVal); die();
        return $countVal;
    }

    protected function getPlacesForM2Chart($m2Arr, $target)
    {
        $parts = Yii::$app->settings->partsM2;
        $maxValue = $target == 1 ? Yii::$app->settings->maxM2 : Yii::$app->settings->maxM2Sell;
        $countVal = [];
        $countVal['count'] = [];
        $countVal['max'] = 0;
        $countVal['min'] = 0;
        if (count($m2Arr) > 0) {
            $m2ArrLimited = array_filter($m2Arr, function ($k) use ($maxValue) {
                return $k <= $maxValue;
            });

            $max = max($m2Arr);
            $min = min($m2Arr);
            $delta = round($maxValue / $parts);

            $countVal['count'] = $this->getRanges($m2ArrLimited, $delta, $parts);
            $countVal['maxVal'] = $maxValue;
            $countVal['max'] = $max;
            $countVal['min'] = $min;
        }
        return $countVal;
    }

    protected function getPlacesForPriceChart($prices, $target)
    {
        $parts = Yii::$app->settings->partsPrice;
        $maxValue = $target == 1 ? Yii::$app->settings->maxPrice : Yii::$app->settings->maxPriceSell;
        $countVal['count'] = [];
        $countVal['max'] = 0;
        $countVal['min'] = 0;

        if (count($prices) > 0) {
            $pricesLimited = array_filter($prices, function ($k) use ($maxValue) {
                return $k <= $maxValue;
            });

            $min = min($prices);
            $max = max($prices);
            $delta = round($maxValue / $parts);

            $countVal['count'] = $this->getRanges($pricesLimited, $delta, $parts);
            $countVal['maxVal'] = $maxValue;
            $countVal['max'] = $max;
            $countVal['min'] = $min;
        }
//debug($countVal); die();
        return $countVal;
    }


    protected function getRanges($arr, $delta, $parts)
    {
        $countVal = array_fill(0, $parts + 1, 0);
        foreach ($arr as $k => $val) {
            $index = floor($val / $delta);
            if ($index >= $parts) $index = $parts - 1;
            $countVal[$index] += 1;
        }
        $countVal[$parts] = 0;
        return $countVal;
    }

}


/* time test
$start = microtime(true);
$time = microtime(true) - $start;
echo count($type1).'time='.$time;
echo 'min1='.$min1.' min2='.$min2. ' max1='.$max1.' maxn2='.$max2.' time='.$time;
*/

