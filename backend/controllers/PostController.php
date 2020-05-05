<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use common\models\SystemFiles;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Imagine\Image\Point;

use common\models\BcPlaces;
use common\models\BcPlacesPrice;
use common\models\BcValutes;
use common\models\BcItems;
use common\models\BcPlacesView;
use yii\helpers\ArrayHelper;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AdminController
{
//запросы для выдачи Офисов
    public function actionTest2()
    {
        $start = microtime(true);
        //запрос всех строк по условиям фильтра для подсчета кол-ва найденных офисов и для графиков цены и площадей
        //совпадает с запросом для выдачи БЦ
        $fullQuery = BcPlacesView::find()
            //->where(['city_id' => 1])
            //->asArray()
            ->all();
        $fullQuery = getUniqueArray('pid', $fullQuery);
        $time1 = microtime(true) - $start;

        $time3 = microtime(true) - $start;


        return $this->render('test2', [
            'fullQuery' => $fullQuery,
            'time1' => $time1,
            'time3' => $time3,
        ]);
    }

//запросы для выдачи БЦ
    public function actionTest3()
    {
        $start = microtime(true);
        $attr = ['id',
            'MIN(con_price) as con_price',
            'MIN(uah_price) as minPrice',
            'MAX(uah_price) as maxPrice',
            'MIN(m2) as minM2',
            'MIN(m2min) as minM2min',
            'MAX(m2) as maxM2',
            'updated_at'];

        $items = BcPlacesView::find()
            ->select($attr)
            //->asArray()
            ->limit(200)
            ->offset(0)
            //->orderBy('con_price, minPrice ASC')
            //->orderBy('maxPrice DESC')
            //->orderBy('minM2min, minM2 ASC')
            //->orderBy('maxM2 DESC')
            //->orderBy('updated_at ASC')
            //->with('bcitem')
            ->orderBy('id')
            ->groupBy(['id'])
            ->all();
        $time1 = microtime(true) - $start;

        $ids = ArrayHelper::getColumn($items, 'id');
        $bcPlaces = BcPlacesView::find()
            //->select(['id', 'pid'])
            ->where(['in', 'id', $ids])
            ->orderBy('id')
            //->asArray()
            //->with('place')
            ->all();
        $time2 = microtime(true) - $start;
        $bcPlaces = getUniqueArray('pid', $bcPlaces);
//debug(ArrayHelper::getColumn($placesForPage, 'pid'));
        $allForPage = [];

        foreach ($items as $key => $item) {
            $allForPage[$key]['bc'] = $item;
            $places = [];
            foreach ($bcPlaces as $place) {
                if ($place['id'] == $item['id']) {
                    $places = ArrayHelper::merge($places, [$place]);
                    $allForPage[$key]['places'] = $places;
                    /*if($place->uah_price == $item->minPrice){
                        if($place->kop>0 || $place->tax==1 || $place->tax==5 || $place->opex>0){
                            $allForPage[$key]['plus']=1;
                        }
                    }*/
                }
            }
        }

        //запрос всех строк по условиям фильтра для подсчета кол-ва найденных офисов и для графиков цены и площадей
        $fullQuery = BcPlacesView::find()
            //->where(['city_id' => 1])
            ->asArray()
            ->all();
        $fullQuery = getUniqueArray('pid', $fullQuery);

        /*$pids = count(array_unique(ArrayHelper::getColumn($fullQuery, 'pid'))); //count ofices
        $m2 = array_unique(ArrayHelper::getColumn($fullQuery, 'm2')); //m2 array
        $m2min = array_unique(ArrayHelper::getColumn($fullQuery, 'm2min')); //m2min array
        $m2ForChart = array_unique(ArrayHelper::merge($m2, $m2min)); //all m2 array
        $pricesForChart = array_unique(ArrayHelper::getColumn($fullQuery, 'uah_price')); //prices array*/


        $time3 = microtime(true) - $start;

        return $this->render('test', [
            'items' => $allForPage,
            //'places' => $allArr,
            //'fullQuery' => $fullQuery,
            //'time1' => $time1,
            //'time2' => $time2,
            //'time3' => $time3,
            //'count_offices' => $pids
        ]);
    }

    public function actionTest()
    {
        //выбираю все БЦ
        //$attr = BcItems::attributes(); SELECT DISTINCT `id`, `con_price`, `uah_price` FROM `bc_places_view` ORDER BY `con_price`, `uah_price` LIMIT 8
        $start = microtime(true);
        $itemsForPage = BcPlacesView::find()
            ->select(['id', 'con_price', 'uah_price'])
            ->distinct()
            ->asArray()
            ->limit(8)
            ->offset(0)
            ->orderBy('con_price ASC, uah_price ASC')
            ->all();
        $time1 = microtime(true) - $start;
        $ids = ArrayHelper::getColumn($itemsForPage, 'id');
        $bcPlacesView = BcPlacesView::find()
            ->select(['id', 'pid'])
            ->where(['in', 'id', $ids])
            //->with('bcitem', 'place')
            ->asArray()
            ->all();
        $time2 = microtime(true) - $start;

        //$bcItemsWithPlaces[0] = [$bcPlacesView[0]['id'], $itemsArray];
        /*foreach($bcPlacesView as $key => $item){
            if($bcItemsWithPlaces[$key][0] == $item['id']){
                $itemsArray = ArrayHelper::merge($itemsArray, $item);
                $bcItemsWithPlaces[$key][1] = $itemsArray;
            } else {
                $bcItemsWithPlaces[$key] = [$item['id'], $item];
            }
        }*/
        //$firstKey = $bcPlacesView[0]['id'];
        //$bcItemsWithPlaces[$firstKey] = [];

        $id = 0;
        $pid = 0;
        $arr = [];
        $itemsArray = [];
        foreach ($bcPlacesView as $item) {
            if ($id == $item['id']) {
                if ($pid != $item['pid']) {
                    //$itemsArray = ArrayHelper::merge($itemsArray, [$item['pid']]);
                    $itemsArray = ArrayHelper::merge($itemsArray, [$item]);
                    $arr[$item['id']] = $itemsArray;
                }
            } else {
                //$itemsArray = [$item['pid']];
                $itemsArray = [$item];
                $arr[$item['id']] = $itemsArray;
            }
            $id = $item['id'];
            $pid = $item['pid'];
        }


        return $this->render('test', [
            'items' => $ids,
            'bcItemsWithPlaces' => $arr,
            'time1' => $time1,
            'time2' => $time2,
        ]);
    }


    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //delete tmp images if exist
        if (SystemFiles::find()->where(['=', 'attachment_type', 'post'])->andWhere(['LIKE', 'attachment_id', 'post'])->count() > 0) {
            SystemFiles::deleteAll([
                'AND',
                ['=', 'attachment_type', 'post'],
                ['LIKE', 'attachment_id', 'post'],
            ]);
        }

        $valutes = BcValutes::find()->asArray()->all();
        $places = BcPlaces::find()->where(['id' => 18748])->one(); //all();
        $places->calcPrice();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->enabled = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing InfoblocksHowtouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function actionUploadImage($allwoedFiles = NULL)
    {

        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
            if (empty($file)) exit;
            $file = $file[0];
            return SystemFiles::uploadImage($file, $allwoedFiles);
        }
        return false;
    }

    public function actionDeleteImage()
    {
        if (($model = SystemFiles::findOne(Yii::$app->request->post('key')))) {
            return true;
        } else {
            throw new NotFoundHttpException('Изображение не удалено');
        }
    }

    public function actionSortImage($id)
    {
        if (Yii::$app->request->isAjax) {
            SystemFiles::sortImage($id);
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }


    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderPartial($view, $params);
        }
        return parent::render($view, $params);
    }*/
}
