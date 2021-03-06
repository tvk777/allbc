<?php

namespace backend\controllers;

use common\models\BcCharacteristics;
use common\models\BcItemsCharacteristics;
use Yii;
use common\models\BcItems;
use common\models\BcItemsSearch;
use common\models\BcPlaces;
use common\models\Geo;
use common\models\GeoSubways;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\SystemFiles;
use yii\helpers\ArrayHelper;

/**
 * BcItemsController implements the CRUD actions for BcItems model.
 */
class BcItemsController extends AdminController
{
    /**
     * Lists all BcItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BcItemsSearch();
        $params = Yii::$app->request->queryParams;
        $params['BcItemsSearch']['single_office'] = 0; //фильтр только БЦ (без отдельных офисов)
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BcItems model.
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




    public function getAllCharacteristics($id = null)
    {
        $characteristics = BcCharacteristics::find()->all();
        $itemsChars = $id === null ? [] : BcItemsCharacteristics::find()->where(['item_id' => $id])->asArray()->all();
        foreach ($characteristics as $one) {
            $one->value['ru'] = '';
            $one->value['ua'] = '';
            $one->value['en'] = '';
            if (!empty($itemsChars)) {
                foreach ($itemsChars as $item) {
                    if ($one->id == $item['characteristic_id']) {
                        $one->value['ru'] = $item['value'];
                        $one->value['ua'] = $item['value_ua'];
                        $one->value['en'] = $item['value_en'];
                    }
                }
            }
        }
        return $characteristics;
    }

    /**
     * Creates a new BcItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BcItems();
        $characteristics = $this->getAllCharacteristics();
        if ($model->load(Yii::$app->request->post())) {
            $data = array_map('array_filter', Yii::$app->request->post('characteristics'));
            $data = array_filter($data);
            $model->formCharacteristics = $data;
            $model->single_office = 0; //not single office

            if ($model->save()) {
                if ((Yii::$app->request->post('save')) == 1) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }

                if (null !== (Yii::$app->request->post('close'))) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'characteristics' => $characteristics
        ]);
    }

    /**
     * Updates an existing BcItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (null !== (Yii::$app->request->post('cancel'))) {
            return $this->redirect(['index']);
        }

        $model = BcItems::find()->where(['id' => $id])->with('subways.subwayDetails')->one();
        //debug($model->slug); die();
        $model->alias = $model->slug->slug;
        $model->cityName = $model->city ? $model->city->name : '';
        $model->countryName = $model->country ? $model->country->name : '';
        $model->districtName = $model->district ? $model->district->name : '';
        $model->latlng = $model->lat . ', ' . $model->lng;

        $dataProvider = $this->getProvider($id, 0);
        $dataProviderArh = $this->getProvider($id, 1);


        $characteristics = $this->getAllCharacteristics($id);

        if ($model->load(Yii::$app->request->post())) {
            $data = array_map('FilterAndTrim', Yii::$app->request->post('characteristics'));
            $data = array_filter($data);
            $model->formCharacteristics = $data;

            if ($model->save()) {
                if ((Yii::$app->request->post('save')) == 1) {
                    $characteristics = $this->getAllCharacteristics($id);

                    return $this->render('update', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'dataProviderArh' => $dataProviderArh,
                        'characteristics' => $characteristics
                    ]);
                }

                if (null !== (Yii::$app->request->post('close'))) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'dataProviderArh' => $dataProviderArh,
            'characteristics' => $characteristics
        ]);
    }

    public function getProvider($id, $arh)
    {
        $query = BcPlaces::find()->where(['item_id' => $id])->andWhere(['archive' => $arh]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function actionUploadImage($field = 'imgs', $allwoedFiles = NULL)
    {

        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
            if (empty($file)) exit;
            $file = $file[0];
            return SystemFiles::uploadImage($file, $field, $allwoedFiles);
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


    /**
     * Deletes an existing BcItems model.
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

    public function actionDeleteSelected()
    {
        if(Yii::$app->request->post('selection')){
            $ids = Yii::$app->request->post('selection');
            foreach ($ids as $id) {
                $this->findModel($id)->delete();
            }
        }
        return $this->redirect(['index']);
    }


    public function actionGetSubway()
    {
        if (Yii::$app->request->isAjax) {

            $result_subways = Geo::getSubwaysByLatLng(Yii::$app->request->post('latlng'));
            //debug(Yii::$app->request->post('latlng'));
            if ($result_subways != 0) {
                $result_subway = reset($result_subways);
                $range = Geo::getDirection(Yii::$app->request->post('placelatlng'), "place_id:" . $result_subway['place_id']);
                if ($subway = GeoSubways::find()->where(['place_id' => $result_subway['place_id']])->one()) {
                    $result[] = array('id' => $subway->id, 'name' => $subway->name, 'place_id' => $subway->place_id);
                } else {
                    try {
                        $subway = new GeoSubways();
                        $subway->name = $result_subway['name'];
                        $subway->lat = $result_subway['lat'];
                        $subway->lng = $result_subway['lng'];
                        $subway->place_id = $result_subway['place_id'];
                        $subway->save();
                        $result[] = array('id' => $subway->id, 'name' => $subway->name, 'place_id' => $subway->place_id);
                    } catch (ErrorException $ex) {
                        Yii::warning("Ошибка геокодирования");
                    }
                }

                if (isset($result)) {
                    if ($range != 0) {
                        $range['walk_seconds'] = round($range['walk_seconds'] / 60);
                        $result[0] = array_merge($result[0], $range);
                    }
                }
                return json_encode($result);
            }


        }
    }

    /**
     * Finds the BcItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BcItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BcItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionChangeAttachmentType()
    {
        SystemFiles::updateAll(['attachment_type' => 'bc_items'], [
            'attachment_type' => 'allbc\Bc\Models\Item'
        ]);
        return 'ready';
    }

    //для вставки общей площади здания в таблицу bc_items из характеристик БЦ
    public function actionTotal()
    {
        $model = BcItems::find()->all();
        $total = [];
        $errors = [];
        foreach ($model as $key => $one) {
            $chars = json_decode($one->characteristics, true);
            if (!empty($chars) && !empty($chars[0])) {
                if (strpos($chars[0]['col2'], 'кв.м') || strpos($chars[0]['col2'], 'м²')) {
                    $val = (float)str_replace(' ', '', $chars[0]['col2']);
                    $total[$key]['val'] = $val;
                    $total[$key]['item'] = $one->id;
                    $total[$key]['char'] = $chars[0]['col2'];
                    $one->total_m2 = $val;
                    if (!$one->save()) $errors[] = $one->getErrors();
                }
            }
        }
        return $this->render('total', [
            'total' => $total,
            'errors' => $errors,
        ]);
    }

    //вставка названия улицы из адреса
    //после автоматической вставки просмотреть и втсавить вручную те адреса, которые не вставились
    /*public function actionStreets()
    {
        $model = BcItems::find()->all();
        foreach ($model as $item) {
            $item->street = $this->clearStreet($item->address);
            $item->save();
        }

        return '123';
    }

    private function clearStreet($str)
    {

        $string = preg_replace("/^(.+?)[0-9].+$/", '\\1', $str);
        $string = preg_replace('/\d/', '', $string);
        $code_match = array('-', ',', '.', '/');
        $string = str_replace($code_match, '', $string);
        return $string;
    }*/

    //проверить координаты адресов, в которых кроме улицы включен город (Мариуполь, Краматорск и т.п.)
    //для вставки англ. названий поменять язык в параметрах ф-ции и в поле модели
    /*public function actionCoordinates()
    {
        $models = BcItems::find()->where(['>', 'id', 32265])->limit(300)->all();

        $adresses = [];
        foreach ($models as $item) {
            $adress = $item->city->name . ' ' . $item->street;
            $adresses[] = $adress;
            $geo = Geo::getStreetLocationByAddress($adress, 'en');
            if (!empty($geo)) {
                $item->street_en = $geo['name'];
                //$item->lat_str = $geo['lat'];
                //$item->lng_str = $geo['lng'];
                $item->save();
            }
        }

        return debug($adresses);
    }*/

}
