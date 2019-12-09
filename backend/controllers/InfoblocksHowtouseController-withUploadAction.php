<?php

namespace backend\controllers;

use Yii;
use common\models\InfoblocksHowtouse;
use common\models\SystemFiles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * InfoblocksHowtouseController implements the CRUD actions for InfoblocksHowtouse model.
 */
class InfoblocksHowtouseController extends Controller
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
     * Lists all InfoblocksHowtouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InfoblocksHowtouse::find()->localized('ru'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InfoblocksHowtouse model.
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

    public function actionUploadImage()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->post('Image')) {
            $attachment_id = Yii::$app->request->post('Image')['attachment_id'];
            $attachment_type = Yii::$app->request->post('Image')['attachment_type'];
            $file = UploadedFile::getInstanceByName('file');
            $file_size = $file->size;
            $content_type = $file->type;
            $file_name = $file->name;
            $disk_name = SystemFiles::getDiskName($file);
            $path = Yii::getAlias('@uploads').'/'.SystemFiles::getPartitionDirectory($disk_name);
            FileHelper::createDirectory($path);
            if ($file->saveAs($path . DIRECTORY_SEPARATOR . $disk_name)) {
                $image_model = new SystemFiles();
                $image_model->attachment_id = $attachment_id;
                $image_model->attachment_type = $attachment_type;
                $image_model->file_name = $file_name;
                $image_model->disk_name = $disk_name;
                $image_model->file_size = $file_size;
                $image_model->content_type = $content_type;
                $image_model->save();
            }
            return true;
        }
    }


    /**
     * Creates a new InfoblocksHowtouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /**
     * Creates a new InfoblocksHowtouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfoblocksHowtouse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
//debug($model->img->imgSrc); die();
       // $img =  SystemFiles::getImgSrc($model->img->disk_name);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            //'img' => $img,
        ]);
    }

    /**
     * Deletes an existing InfoblocksHowtouse model.
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
     * Finds the InfoblocksHowtouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfoblocksHowtouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = InfoblocksHowtouse::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
