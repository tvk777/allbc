<?php

namespace backend\controllers;

use Yii;
use common\models\Social;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SocialController implements the CRUD actions for Social model.
 */
class SocialController extends Controller
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
     * Lists all Social models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Social::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Social model.
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
     * Creates a new Social model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Social();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if (!empty($model->file)) {
                $model->file->saveAs(Yii::getAlias('@uploads') . 'soc_' . $imageName . '.' . $model->file->extension);
                $model->icon = 'soc_' . $imageName . '.' . $model->file->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Social model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if (!empty($model->file)) {
                $model->file->saveAs(Yii::getAlias('@uploads') . '/soc_' . $imageName . '.' . $model->file->extension);
                $model->icon = 'soc_' . $imageName . '.' . $model->file->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDeleteimage($id)
    {
        $model = $this->findModel($id);
        $imgName = $model->icon;
        unlink(Yii::getAlias('@uploads').'/'.$imgName);
        $model->icon = null;
        $model->update();
        if (Yii::$app->request->isAjax)
        {
            return 'Deleted';
        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing Social model.
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
     * Finds the Social model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Social the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Social::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
