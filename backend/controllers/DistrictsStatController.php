<?php

namespace backend\controllers;

use common\models\BcItems;
use common\models\BcPlaces;
use Yii;
use common\models\DistrictsStat;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
/**
 * DistrictsStatController implements the CRUD actions for DistrictsStat model.
 */
class DistrictsStatController extends AdminController
{
    /**
     * Lists all DistrictsStat models.
     * @return mixed
     */
   public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DistrictsStat::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

//получение статистики для всех районов и заполнение таблицы districts_stat
    /*public function actionAllStat()
    {
        $districts = DistrictsStat::find()->with('items')->all();
        $errors = [];
        $test = [];
        foreach($districts as $key => $district){
            $items = $district->items;
            $totalM2 = $district->sumItemsM2;
            $itemsId = ArrayHelper::getColumn($items, 'id');
            $midPrice = '';
            $midSellPrice = '';
            $count=0;
            $countSell =0;
            $freeM2 = '';
            $freeM2Sell = '';
            if(!empty($itemsId)) {
                $places = BcPlaces::find()->where(['archive' => 0])->andWhere(['hide' => 0])->andFilterWhere(['in', 'item_id', $itemsId])->all();
                $count = count($places);
                $placesId = ArrayHelper::getColumn($places, 'id');
                $freeM2 = array_sum (ArrayHelper::getColumn($places, 'm2'));
                //$vacancy = !empty($totalM2) ? round(($placesM2/$totalM2)*100) : '';
                if(!empty($placesId)) {
                    $prices = BcPlacesPrice::find()->where(['valute_id' => 1])->andWhere(['period_id' => 1])->andFilterWhere(['in', 'place_id', $placesId])->all();
                    if(!empty($prices)) {
                        $pricesSum = array_sum(ArrayHelper::getColumn($prices, 'price'));
                        $pricesCount = count($prices);
                        $midPrice = round($pricesSum / $pricesCount);
                    }
                }
                $placesSell = BcPlacesSell::find()->where(['archive' => 0])->andWhere(['hide' => 0])->andFilterWhere(['in', 'item_id', $itemsId])->all();
                $countSell = count($placesSell);
                $placesSellId = ArrayHelper::getColumn($placesSell, 'id');
                $freeM2Sell = array_sum (ArrayHelper::getColumn($placesSell, 'm2'));
                if(!empty($placesSellId)) {
                    $pricesSell = BcPlacesSellPrice::find()->where(['valute_id' => 1])->andWhere(['period_id' => 1])->andFilterWhere(['in', 'place_id', $placesSellId])->all();
                    if(!empty($pricesSell)) {
                        $pricesSellSum = array_sum(ArrayHelper::getColumn($pricesSell, 'price'));
                        $pricesSellCount = count($pricesSell);
                        $midSellPrice = round($pricesSellSum / $pricesSellCount);
                    }
                }
                //$vacancySell = !empty($totalM2) ? round(($placesM2Sell/$totalM2)*100) : '';
            }
            //$district->count = $count;
            $test[$key]['district'] = $district->id;
            $test[$key]['price'] = $midPrice;
            $test[$key]['priceSell'] = $midSellPrice;
            $test[$key]['count'] = $count;
            $test[$key]['countSell'] = $countSell;
            $test[$key]['freeM2'] = $freeM2;
            $test[$key]['freeM2Sell'] = $freeM2Sell;
            $test[$key]['totalM2'] = $totalM2;

            $district->count = $count;
            $district->count_sell = $countSell;
            $district->price = $midPrice;
            $district->price_sell = $midSellPrice;
            $district->free_m2 = $freeM2;
            $district->free_sell_m2 = $freeM2Sell;
            $district->total_m2 = $totalM2;
            if(!$district->save()) $errors[] = $district->getErrors();
        }


        return $this->render('all-stat', [
            'errors' => $errors,
            'test' => $test,
        ]);
    }*/

    //заполнение таблицы districts_stat значениями districts-id из таблицы geo_districts
    /*public function actionFillDistrictsId()
    {
        $errors = [];
        $districts = GeoDistricts::find()->all();
        foreach($districts as $one){
            $model = new DistrictsStat();
            $model->district_id = $one->id;
                if(!$model->save()) $errors[] = $model->getErrors();
        }

        return $this->render('districts-id', [
            'errors' => $errors,
        ]);
    }*/

    /**
     * Displays a single DistrictsStat model.
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
     * Creates a new DistrictsStat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DistrictsStat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DistrictsStat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DistrictsStat model.
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
     * Finds the DistrictsStat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DistrictsStat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistrictsStat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
