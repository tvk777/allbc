<?php

namespace backend\controllers;

use Yii;
use common\models\BcPlacesSell;
use yii\web\NotFoundHttpException;

/**
 * BcPlacesSellController implements the CRUD actions for BcPlacesSell model.
 */
class BcPlacesSellController extends AdminController
{

    /**
     * Creates a new BcPlacesSell model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BcPlacesSell();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BcPlacesSell model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->alias = !empty($model->slug) ? $model->slug->slug : '';
        $model->showm2 = $model->m2range;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //debug($model->upfile); die();
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BcPlacesSell model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the BcPlacesSell model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BcPlacesSell the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = BcPlacesSell::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            //return $this->renderAjax($view, $params);
            return $this->renderPartial($view, $params);
        }
        return parent::render($view, $params);
    }


    /* функции будут нужны для переноса данных с сайта
       сначала запустить actionCreateUrls, потом actionCreateNames
    */
    /*public function actionCreateUrls()
    {
        $model = BcPlacesSell::find()->all();
        foreach($model as $place){
            $city = $place->no_bc===1 ? $place->office->city : $place->bcitem->city;
            $slug = 'prodazha-ofica-'.$place->m2.'-m2-'.$city->name.'-id'.$place->id;
            $alias = Slugs::generateSlug('bc_places_sell', $place->id, $slug);
            Slugs::initialize('bc_places_sell', $place->id, $alias);
        }

        return $this->render('create-names', [
            'model' => $model,
        ]);
    }*/

    /*public function actionCreateNames()
    {
        $model = BcPlacesSell::find()->all();
        foreach($model as $place){
        $name = $place->createName();
        $place->name = $name['ru'];
        $place->name_ua = $name['ua'];
        $place->name_en = $name['en'];
        $place->showm2 = $place->m2range;
        if(!$place->save()) debug($place->getErrors());
        }
        return $this->render('create-names', [
            'model' => $model,
        ]);
    }*/

    /*todo: формирование и заполнение сео-тегов - title, description, keywords (уточнить по поводу точного адреса)
    */



}
