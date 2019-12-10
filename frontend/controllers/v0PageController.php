<?php
namespace frontend\controllers;

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
        $model = BcItems::find()->joinWith(['slug'])->with('subways.subwayDetails')->where(['slug' => $slug])->multilingual()->one();
        $target = Yii::$app->request->get('target');
        $targetId = $target == 'sell' ? 2 : 1;
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

        return $this->render('item', [
            'model' => $model,
            'target' => $targetId,
            'seoClass' => $seoClass,
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
        ]);
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
                'SetHeader' => [$title.'||' . date('d-m-Y')],
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

    public function getFilter($seo, $params = null)
    {
        $searchParams = [];
        $searchParams['city'] = $seo->city->city_id !== 0 ? $seo->city->city_id : '';
        $searchParams['country'] = $seo->country->country_id !== 0 ? $seo->country->country_id : '';
        $searchParams['target'] = $seo->target;

        if (!$params) {
            $searchParams['percent_commission'] = $seo->bc_commission == 1 ? 0 : '';
            $searchParams['classes'] = ArrayHelper::getColumn($seo->classes, 'bc_class_id');
            $searchParams['districts'] = $seo->districts ? ArrayHelper::getColumn($seo->districts, 'district_id') : '';
            $searchParams['m2'] = $seo->m2 ? explode('-', $seo->m2) : '';
            $searchParams['price'] = $seo->price;
            $searchParams['walk_dist'] = '';
            $searchParams['subway'] = '';
        } else {
            //debug($params); die();
            $params['minm2'] = isset($params['minm2']) ? $params['minm2'] : '';
            $params['maxm2'] = isset($params['maxm2']) ? $params['maxm2'] : '';
            $params['districts'] = isset($params['districts']) ? $params['districts'] : [];
            $params['classes'] = isset($params['classes']) ? $params['classes'] : [];
            $params['statuses'] = isset($params['statuses']) ? $params['statuses'] : [];
            $params['comission'] = isset($params['comission']) ? $params['comission'] : '';
            $params['walk_dist'] = isset($params['walk_dist']) ? $params['walk_dist'] : '';
            $params['subway'] = isset($params['subway']) ? $params['subway'] : '';
            $params['user'] = isset($params['user']) ? $params['user'] : '';

            $searchParams['m2'] = $params['minm2'] != '' || $params['maxm2'] != '' ? [$params['minm2'], $params['maxm2']] : '';
            $searchParams['districts'] = count($params['districts']) > 0 ? $params['districts'] : '';
            $searchParams['classes'] = count($params['classes']) > 0 ? $params['classes'] : '';
            $searchParams['statuses'] = count($params['statuses']) > 0 ? $params['statuses'] : '';
            $searchParams['percent_commission'] = $params['comission'] == 'on' ? 0 : '';
            $searchParams['walk_dist'] = !empty($params['walk_dist']) ? $params['walk_dist'] : '';
            $searchParams['subway'] = !empty($params['subway']) ? $params['subway'] : '';
            $searchParams['user'] = !empty($params['user']) ? $params['user'] : '';
        }
        //debug($searchParams); die();
        return $searchParams;
    }

    //страница выдачи каталога
    public function actionSeo_catalog_urls($slug)
    {
        $seo = SeoCatalogUrls::find()
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

        $whereCondition = [];

        //debug(Yii::$app->request->get()); die();

        if (Yii::$app->request->isPjax && Yii::$app->request->post('visibles')) {
            $visibles = Yii::$app->request->post('visibles');
            if (count($visibles) > 0) {
                $whereCondition['visibles'] = $visibles;
                $whereCondition['target'] = $seo->target;
            }
        } elseif ($params = Yii::$app->request->get('filter')) {
            $whereCondition = $this->getFilter($seo, $params);
        } else {
            $whereCondition = $this->getFilter($seo);
        }

        $searchModel = new BcItemsSearch();
        $result = $searchModel->seoSearch($whereCondition);
        $query = $result['query'];
//debug($result); die();
        $countQuery = clone $query;

        $countPlaces = Yii::t('app', 'Found: {countPlaces} offices', [
            'countPlaces' => count($result['places']),
        ]);
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 8]);
        $pages->pageSizeParam = false;
        $pages->forcePageParam = false;
        $items = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $targetLinks = SeoCatalogUrls::find()->where(['id' => 88])->one();
        $mainRent = trim($targetLinks->main_rent_link_href, '/');
        $mainSell = trim($targetLinks->main_sell_link_href, '/');


        //debug($this->getDataForFilter($city)['branches']); die();
        return $this->render('items', [
            'seo' => $seo,
            'city' => $city,
            'items' => $items,
            'countPlaces' => $countPlaces,
            'pages' => $pages,
            'markers' => $result['markers'],
            'center' => json_encode($center),
            'zoom' => $zoom,
            'm2' => $whereCondition['m2'],
            'places' => $result['places'],
            'countValM2' => $this->getPlacesCountForCharts($result['places_for_charts']),
            'filters' => $this->getDataForFilter($city_id),
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
            'params' => $params
        ]);
    }

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


}
