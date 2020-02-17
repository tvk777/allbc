<?php

namespace backend\controllers;

use Yii;
use common\models\SystemFiles;
use yii\web\NotFoundHttpException;

/**
 * SystemFilesController implements the CRUD actions for SystemFiles model.
 */
class SystemFilesController extends AdminController
{
    /**
     * Updates an existing SystemFiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateSlide($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update-slide', [
            'model' => $model,
        ]);
    }



    /**
     * Finds the SystemFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SystemFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SystemFiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function render($view, $params = [])
{
    if (\Yii::$app->request->isAjax) {
        return $this->renderPartial($view, $params);
    }
    return parent::render($view, $params);
}
    
}
