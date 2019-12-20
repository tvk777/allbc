<?php

namespace backend\controllers;

use Yii;
use common\models\BcPlaces;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\SystemFiles;
use yii\helpers\Html;
use common\models\Slugs;

/**
 * BcPlacesController implements the CRUD actions for BcPlaces model.
 */
class BcPlacesController extends Controller
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
     * Creates a new BcPlaces model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BcPlaces();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BcPlaces model.
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
     * Deletes an existing BcPlaces model.
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


    public function actionUploadImage($field='imgs', $allwoedFiles = NULL)
    {

        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
            if (empty($file)) exit;
            $file = $file[0];
            return SystemFiles::uploadImage($file, $field, $allwoedFiles);
        }
        return false;
    }
    public function actionUploadStageImage($field='stage_img', $allwoedFiles = NULL)
    {

        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstanceByName('stageImg');
            //debug($file); die();
            if (empty($file)) exit;
            //$file = $file[0];
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
     * Finds the BcPlaces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BcPlaces the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = BcPlaces::findOne($id)) !== null) {
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
    public function actionCreateNames()
    {
        $model = BcPlaces::find()->all();
        foreach($model as $place){
            $place->createName();
        }

        return $this->render('create-names', [
            'model' => $model,
        ]);
    }

    public function actionCreateUrls()
    {
        $model = BcPlaces::find()->all();
        foreach($model as $place){
            $slug = 'arenda-ofica-'.$place->m2.'-m2-'.$place->bcitem->city->name.'-id'.$place->id;
            $alias = Slugs::generateSlug('bc_places', $place->id, $slug);
            Slugs::initialize('bc_places', $place->id, $alias);
        }

        return $this->render('create-names', [
            'model' => $model,
        ]);
    }
    todo: формирование и заполнение сео-тегов - title, description, keywords (уточнить по поводу точного адреса)
    */



}
