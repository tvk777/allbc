<?php
namespace frontend\controllers;

use common\models\BcPlacesPrice;
use common\models\BcPlacesSellPrice;
use common\models\BcValutes;
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
class PageController extends Controller
{

    public function actionServices($slug)
    {
        $model = Services::find()->joinWith(['slug'])->where(['slug' => $slug])->multilingual()->one();
        return $this->render('service', [
            'model' => $model,
        ]);
    }


    //страница бизнес-центра
    public function actionBc_items($slug)
    {
        $target = Yii::$app->request->get('target');
        $targetId = $target == 'sell' ? 2 : 1;

        $query = BcItems::find()->joinWith(['slug']);
        if($targetId==2) {
            $query->with('subways.subwayDetails', 'characteristics.characteristic', 'brokers', 'owners', 'placesSell.prices');
        } else {
            $query->with('subways.subwayDetails', 'characteristics.characteristic', 'brokers', 'owners', 'places.prices');
        }

        $model = $query->where(['slug' => $slug])->multilingual()->one();

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
        if(!(count($viewCounter)>0)) {
            $viewCounter = new ViewsCounter();
            $viewCounter->item_id = $model->id;
            $viewCounter->model = 'bc_items';
            $viewCounter->count_view = 0;
            $viewCounter->save();
        }
        $viewCounter->processCountViewItem();

        return $this->render('item', [
            'model' => $model,
            'target' => $targetId,
            'seoClass' => $seoClass,
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
        ]);
    }

    public function actionOrder($id)
    {
        $model = new OrderForm();
        $broker = User::findOne($id);
        $model->toEmail = $broker->email;
        $model->subject = 'subject';//'Заявка на просмотр для '.$broker->name. ' '.$broker->surname;
//debug($model->toEmail); die();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendOrder()) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->renderAjax('order', [
                'model' => $model,
                'user' => $broker
            ]);
        }
    }

    public function actionPdf($id, $target)
    {
        $model = BcItems::find()->where(['id' => $id])->multilingual()->one();
        $currentLanguage = Yii::$app->language;
        $title = getDefaultTranslate('title', $currentLanguage, $model);
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
        $currentLanguage = Yii::$app->language;
        $searchParams = [];
        $searchParams['result'] = !empty($params['result']) ? $params['result'] : 'bc';
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
            $searchParams['percent_commission'] = $seo->bc_commission == 1 ? 0 : '';
            $searchParams['classes'] = ArrayHelper::getColumn($seo->classes, 'bc_class_id');
            $searchParams['districts'] = $seo->districts ? ArrayHelper::getColumn($seo->districts, 'district_id') : '';
            $searchParams['price'] = $seo->price;
            $searchParams['walk_dist'] = '';
            $searchParams['subway'] = '';
        } else {
            
            $params['m2min'] = isset($params['m2min']) ? $params['m2min'] : '';
            $params['m2max'] = isset($params['m2max']) ? $params['m2max'] : '';
            $params['districts'] = isset($params['districts']) ? $params['districts'] : [];
            $params['classes'] = isset($params['classes']) ? $params['classes'] : [];
            $params['statuses'] = isset($params['statuses']) ? $params['statuses'] : [];
            $params['comission'] = isset($params['comission']) ? $params['comission'] : '';
            $params['walk_dist'] = isset($params['walk_dist']) ? $params['walk_dist'] : '';
            $params['subway'] = isset($params['subway']) ? $params['subway'] : '';
            $params['user'] = isset($params['user']) ? $params['user'] : '';
            $params['visibles'] = isset($params['visibles']) ? $params['visibles'] : [];

            $searchParams['m2min'] = $params['m2min'];
            $searchParams['m2max'] = $params['m2max'];
            $searchParams['districts'] = count($params['districts']) > 0 ? $params['districts'] : '';
            $searchParams['classes'] = count($params['classes']) > 0 ? $params['classes'] : '';
            $searchParams['statuses'] = count($params['statuses']) > 0 ? $params['statuses'] : '';
            $searchParams['percent_commission'] = $params['comission'] == 'on' ? 0 : '';
            $searchParams['walk_dist'] = !empty($params['walk_dist']) ? $params['walk_dist'] : '';
            $searchParams['subway'] = !empty($params['subway']) ? $params['subway'] : '';
            $searchParams['user'] = !empty($params['user']) ? $params['user'] : '';
            $searchParams['visibles'] = !empty($params['visibles']) ? $params['visibles'] : [];

            $searchParams['pricemin'] = !empty($params['pricemin']) ? $params['pricemin'] : '';
            $searchParams['pricemax'] = !empty($params['pricemax']) ? $params['pricemax'] : '';
            $searchParams['currency'] = !empty($params['currency']) ? $params['currency'] : 1;
            $searchParams['type'] = !empty($params['type']) ? $params['type'] : 1;
        }
        return $searchParams;
    }

    //тестирование выдачи по условиям фильтров
    public function actionTestitems()
    {
        $whereCondition['result'] = 'offices'; //'bc'; //
        $whereCondition['target'] = 1;
        $whereCondition['city'] = 5;
        $whereCondition['sort'] = 'm2_desc';
        $whereCondition['lang'] = 'ua';
        $whereCondition['m2'] = [35, 150];
        $whereCondition['price'] = [70, 90];
        //$whereCondition['user'] = 259;
        //$whereCondition['subway'] = 1;
        //$whereCondition['walk_dist'] = 1500;
        //$whereCondition['classes'] = [1];
        //$whereCondition['districts'] = [7];
        //$whereCondition['visibles'] = [31792, 31627, 32171];

        $searchModel = new BcItemsSearch();
        $result = $searchModel->seoSearch($whereCondition);

        return $this->render('test-items', [
            'test' => $result
        ]);
    }

    //страница выдачи каталога
    public function actionSeo_catalog_urls($slug)
    {
        $seo = SeoCatalogUrls::find()
            ->with('city')
            ->joinWith(['slug'])
            //->with('city', 'classes', 'branch', 'country', 'districts', 'statuses', 'subways')
            ->where(['slug' => $slug])
            ->multilingual()
            ->one();

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
        $params = [];

        if (Yii::$app->request->get('filter')) $params = Yii::$app->request->get('filter');
        if (Yii::$app->request->get('sort')) $params['sort'] = Yii::$app->request->get('sort');

        if (Yii::$app->request->isPjax) {
            if (Yii::$app->request->post('visibles') && Yii::$app->request->post('visibles') != 0) $params['visibles'] = Yii::$app->request->post('visibles');
            if (Yii::$app->request->post('center') && Yii::$app->request->post('center') != 0) $center = Yii::$app->request->post('center');
            if (Yii::$app->request->post('zoom') && Yii::$app->request->post('zoom') != 0) $zoom = Yii::$app->request->post('zoom');
        }


        $whereCondition = $this->getFilter($seo, $params);

        $searchModel = new BcItemsSearch();
        $result = $searchModel->seoSearch($whereCondition);

        //$countPlacesNum = $params['result']=='bc' ? count($result['places']) : count($result['places']);
        $countPlaces = Yii::t('app', 'Found: {countPlaces} offices', [
            'countPlaces' => count($result['places']),
        ]);

        $targetLinks = SeoCatalogUrls::find()->where(['id' => 88])->one();
        $mainRent = trim($targetLinks->main_rent_link_href, '/');
        $mainSell = trim($targetLinks->main_sell_link_href, '/');
        $currency = !empty($params['currency']) ? $params['currency'] : 1;
        $rate = BcValutes::getRate($currency);
        return $this->render('items', [
            'seo' => $seo,
            'city' => $city,
            'items' => $result['bcItems'],
            'countPlaces' => $countPlaces,
            'pages' => $result['pages'],
            'markers' => $result['markers'],
            'center' => json_encode($center),
            'zoom' => $zoom,
            'places' => $result['places'],
            'countValM2' => $this->getPlacesForM2Chart($result['places_for_charts']),
            'filters' => $this->getDataForFilter($city_id),
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
            'params' => $params,
            'conditions' => $whereCondition,
            'pricesChart' => $this->getPlacesForPriceChart($result['places_for_charts'], $seo->target),
            'rate' => $rate['rate']
        ]);
    }

    public function actionBars()
    {        
        if (Yii::$app->request->isPjax) {
            $bars = unserialize(Yii::$app->request->post('bars')[0]);
            $type = Yii::$app->request->post('type');
            $currency = Yii::$app->request->post('currency');
            $rate = BcValutes::getRate($currency);
            return $this->renderAjax('_partial/_bars', [
                'bars' => $bars,
                'type' => $type,
                'rate' => $rate['rate'],
                'currency' => $currency,
            ]);
        }
        return false;
    }

    protected function getDataForFilter($city)
    {
        $filters = [];
        $districts = GeoDistricts::find();
        $subways = GeoSubways::find();
        if ($city != 0) {
            $where = ['city_id' => $city];
        }
        if (!empty($where)) {
            $districts->where($where);
            $subways->where($where);
        }
        $filters['subways'] = $subways = $subways->all();
        $branches = array_unique(ArrayHelper::getColumn($subways, 'branch_id'));
        $branches = array_filter($branches, function ($value) {
            return !is_null($value) && $value !== '';
        });
        sort($branches);
        $filters['branches'] = $branches;
        $filters['district'] = $districts->all();

        $filters['classes'] = BcClasses::find()->all();
        $filters['statuses'] = BcStatuses::find()->all();

        return $filters;
    }

    protected function getPlacesForM2Chart($places)
    {
        $countVal = [];
        $countVal['count'] = [];
        $countVal['max'] = 0;
        $countVal['min'] = 0;
        if (count($places) > 0) {
            $m2s = ArrayHelper::getColumn($places, 'm2');
            $max = max($m2s);
            $min = min($m2s);
            $delta = round($max / 30);

            $countVal['count'] = $this->getRanges($m2s, $delta);
            $countVal['max'] = $max;
            $countVal['min'] = $min;
        }
        //debug($countVal); die();

        return $countVal;
    }

    protected function getPlacesForPriceChart($places, $target)
    {
        $countVal['type1']['count'] = [];
        $countVal['type1']['max'] = 0;
        $countVal['type1']['min'] = 0;
        $countVal['type3']['count'] = [];
        $countVal['type3']['max'] = 0;
        $countVal['type3']['min'] = 0;

        if (count($places) > 0) {
            $placesIds = ArrayHelper::getColumn($places, 'id');
            if ($target == 1) {
                $query = BcPlacesPrice::find();
            } else {
                $query = BcPlacesSellPrice::find();
            }
            $query->select(['price', 'period_id'])->where(['valute_id' => 1]);
            $query->andWhere(['or', ['period_id' => 1], ['period_id' => 3]]);
            $query->andWhere(['in', 'place_id', $placesIds]);
            $query->orderBy('price');
            $prices = $query->asArray()->all();

            $type1 = []; //$/м²/mec 'period_id' => 1
            $type3 = []; //$/mec 'period_id' => 3
            if (count($prices) > 0) {
                foreach ($prices as $price) {
                    if ($price['period_id'] == 1) {
                        $type1[] = $price;
                    } else {
                        $type3[] = $price;
                    }
                }


                $pr1 = ArrayHelper::getColumn($type1, 'price');
                if(count($pr1)>0) {
                    $minType1 = min($pr1);
                    $maxType1 = max($pr1);
                    $delta = round($maxType1 / 30);
                    $countVal['type1']['count'] = $this->getRanges($pr1, $delta);
                    $countVal['type1']['max'] = $maxType1;
                    $countVal['type1']['min'] = $minType1;
                }

                $pr2 = ArrayHelper::getColumn($type3, 'price');
                if(count($pr2)>0) {
                    $minType3 = min($pr2);
                    $maxType3 = max($pr2);
                    $delta3 = round($maxType3 / 30);
                    $countVal['type3']['count'] = $this->getRanges($pr2, $delta3);
                    $countVal['type3']['max'] = $maxType3;
                    $countVal['type3']['min'] = $minType3;
                }

            }
        }

        return $countVal;
    }

    protected function getRanges($arr, $delta)
    {
        $countVal = array_fill(0, 30, 0);
        foreach ($arr as $k => $val) {
            $index = floor($val / $delta);
            if($index>=30) $index=29;
            $countVal[$index] += 1;
        }
        return $countVal;
    }


}


/* time test
$start = microtime(true);
$time = microtime(true) - $start;
echo count($type1).'time='.$time;
echo 'min1='.$min1.' min2='.$min2. ' max1='.$max1.' maxn2='.$max2.' time='.$time;
*/

/* вариант с неравномерным распределением по диапазонам
protected function getPlacesCountForCharts($places)
{
    $countVal = [];
    $countVal['count'] = [];
    $countVal['range'] = [];
    $countVal['max'] = 0;
    //debug($places); die();
    if (count($places) > 0) {
        $m2s = ArrayHelper::getColumn($places, 'm2');
        $max = max($m2s);
        //echo $max; die();
        $range = ceil($max / 1000);

        $countVal2 = [];
        $countVal3 = [];
        $countVal4 = [];
        $countRange2 = [];
        $countRange3 = [];
        $countRange4 = [];

        $countVal1 = array_fill(0, 5, 0);
        $countRange1 = array_fill(0, 5, '0-99');
        if ($max >= 100) {
            $countVal2 = array_fill(1, 4, 0);
            $countRange2 = array_fill(1, 4, '100-499');
        }
        if ($max >= 500) {
            $countVal3 = array_fill(1, 1, 0);
            $countRange3 = array_fill(1, 1, '500-999');
        }
        if ($max >= 1000) {
            $countVal4 = array_fill(1, $range, 0);
            $countRange4 = array_fill(1, $range, '1000-' . $max);
        }

        //debug($countVal2); die();

        foreach ($m2s as $k => $val) {
            if ($val < 100) {
                $index = floor($val / 20);
                $countVal1[$index] += 1;
            } elseif ($val >= 100 && $val < 500) {
                $index = floor($val / 100);
                $countVal2[$index] += 1;
            } elseif ($val >= 500 && $val < 1000) {
                $index = floor($val / 500);
                $countVal3[$index] += 1;
            } elseif ($val >= 1000 && $val <= $max) {
                $index = floor($val / 1000);
                $countVal4[$index] += 1;
            }
        }

        $countVal['count'] = array_merge($countVal1, $countVal2, $countVal3, $countVal4);
        $countVal['range'] = array_merge($countRange1, $countRange2, $countRange3, $countRange4);
        $countVal['max'] = $max;
    }
    //debug($countRange3); die();

    return $countVal;
}*/


