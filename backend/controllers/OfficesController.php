<?php

namespace backend\controllers;

use Yii;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use common\models\Geo;
use common\models\GeoSubways;
use common\models\Offices;
use common\models\OfficesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfficesController implements the CRUD actions for Offices model.
 */
class OfficesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Offices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfficesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Offices model.
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
     * Creates a new Offices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $office = new Offices();
        $office->target = 1;
        $place = new BcPlaces();
        $place->no_bc = 1;
        $place->hide_bc = 1;
        $place->plan_comment = 0;
        //$place->showm2 = $place->m2range;

        if ($office->load(Yii::$app->request->post()) && $place->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($office->save()) {
                    $place->item_id = $office->id;
                    if (!$place->save()) {
                        $transaction->rollBack();
                        //return false;
                    }
                } else {
                    $transaction->rollBack();
                    //return false;
                }
            } catch (Exception $exception) {
                $transaction->rollBack();
                //return false;
            }

            $transaction->commit();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'office' => $office,
            'place' => $place
        ]);
    }

    public function actionCreateSell()
    {
        $office = new Offices();
        $office->target = 2;
        $place = new BcPlacesSell();
        $place->no_bc = 1;
        $place->hide_bc = 1;
        $place->plan_comment = 0;

        if ($office->load(Yii::$app->request->post()) && $place->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($office->save()) {
                    $place->item_id = $office->id;
                    if (!$place->save()) {
                        $transaction->rollBack();
                        //return false;
                    }
                } else {
                    $transaction->rollBack();
                    //return false;
                }
            } catch (Exception $exception) {
                $transaction->rollBack();
                //return false;
            }
//debug($transaction);
            $transaction->commit();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'office' => $office,
            'place' => $place
        ]);
    }

    /**
     * Updates an existing Offices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $office = $this->findModel($id);
        $place = $office->place;
//debug($place->name);
        $place->alias = $place->slug ? $place->slug->slug : '';
        $office->cityName = $office->city ? $office->city->name : '';
        $office->countryName = $office->country ? $office->country->name : '';
        $office->districtName = $office->district ? $office->district->name : '';
        $place->latlng = $place->lat . ', ' . $place->lng;
        $place->showm2 = $place->m2range;


        if ($office->load(Yii::$app->request->post()) && $place->load(Yii::$app->request->post())) {
            $isValid = $office->validate();
            $isValid = $place->validate() && $isValid;
            if ($isValid) {
                $office->save(false);
                $place->save(false);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'office' => $office,
            'place' => $place
        ]);
    }

    public function actionUpdateSell($id)
    {
        $office = $this->findModel($id);
        $place = $office->placesell;
//debug($place->name);
        $place->alias = $place->slug ? $place->slug->slug : '';
        $office->cityName = $office->city ? $office->city->name : '';
        $office->countryName = $office->country ? $office->country->name : '';
        $office->districtName = $office->district ? $office->district->name : '';
        $place->latlng = $place->lat . ', ' . $place->lng;
        $place->showm2 = $place->m2range;


        if ($office->load(Yii::$app->request->post()) && $place->load(Yii::$app->request->post())) {
            $isValid = $office->validate();
            $isValid = $place->validate() && $isValid;
            if ($isValid) {
                $office->save(false);
                $place->save(false);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'office' => $office,
            'place' => $place
        ]);
    }


    /**
     * Deletes an existing Offices model.
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

    public function actionGetSubway()
    {
        if (Yii::$app->request->isAjax) {

            $result_subways = Geo::getSubwaysByLatLng(Yii::$app->request->post('latlng'));
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
     * Finds the Offices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Offices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Offices::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
