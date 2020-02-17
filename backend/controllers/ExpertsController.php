<?php

namespace backend\controllers;

use Yii;
use common\models\Experts;
use common\models\Texts;
use common\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * ExpertsController implements the CRUD actions for Experts model.
 */
class ExpertsController extends AdminController
{
    /**
     * Lists all Experts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Experts::find(),
        ]);
        $text = Texts::find()->where(['id' => 4])->multilingual()->one();

        $searchModel = new UserSearch();
        $usersProvider = $searchModel->searchExperts();
        $usersProvider->pagination->pageSize = 10;



        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'text' => $text,
            'searchModel' => $searchModel,
            'usersProvider' => $usersProvider,
        ]);
    }

    /**
     * Creates a new Experts model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $searchModel = new UserSearch();
        $usersProvider = $searchModel->search(Yii::$app->request->queryParams);
        $usersProvider->pagination->pageSize = 10;

        $this->render('create', [
            'searchModel' => $searchModel,
            'usersProvider' => $usersProvider,
        ]);
    }


    public function actionUpdateText()
    {
        $text = Texts::find()->where(['id' => 4])->multilingual()->one();

        if ($text->load(Yii::$app->request->post()) && $text->save()) {
            Yii::$app->session->setFlash('success', 'Текст сохранен');
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }



    public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax($view, $params);
        }
        return parent::render($view, $params);
    }

    /**
     * Updates an existing Experts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {

        if (count(Yii::$app->request->post('selection'))>0) {
            $experts = Yii::$app->request->post('selection');
            //debug($experts);
            $maxOrder = Experts::find()->max('sort_order')+1;
            $errors=[];
            foreach ($experts as $one){
                $expert = new Experts();
                $expert->user_id = $one;
                $expert->active = 1;
                $expert->sort_order = $maxOrder;
                ;
                if(!$expert->save()) $errors[$one] = $expert->getErrors();
                $maxOrder++;                
            }
            if(!empty($errors)) {
                $msg = '';
                foreach($errors as $id => $err){
                    $msg .= 'Errors for User '.$id.':</br>';
                    foreach($err as $er){
                        foreach($er as $e) {
                            $msg .= $e . '</br>';
                        }
                    }
                }
                Yii::$app->session->setFlash('error', $msg);
            }
            return $this->redirect(['index']);
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Experts model.
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
     * Finds the Experts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Experts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Experts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
