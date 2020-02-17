<?php

namespace backend\controllers;

use Yii;
use common\models\InfoblocksHowtouse;
use common\models\SystemFiles;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * InfoblocksHowtouseController implements the CRUD actions for InfoblocksHowtouse model.
 */
class InfoblocksHowtouseController extends AdminController
{
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


    /**
     * Creates a new InfoblocksHowtouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfoblocksHowtouse();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $file = UploadedFile::getInstance($model, 'upload_image');
                if (!empty($file) && $file->size !== 0) {
                    $image = $this->saveImage($file, $model);
                    if ($image->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else{
                    Yii::$app->session->setFlash('error', Yii::t('app', 'need image'));
                }
            }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $file = UploadedFile::getInstance($model, 'upload_image');
            if (!empty($file) && $file->size !== 0) {
                if ($model->img) {
                    $model->img->delete();
                }
                $image = $this->saveImage($file, $model);
                if ($image->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                if (!$model->img) {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'need image'));
                    return $this->render('update', ['model' => $model,]);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function saveImage($file, $model)
    {
        $file_size = $file->size;
        $content_type = $file->type;
        $file_name = $file->name;
        $disk_name = SystemFiles::getDiskName($file);
        $path = Yii::getAlias('@uploads') . '/' . SystemFiles::getPartitionDirectory($disk_name);
        FileHelper::createDirectory($path);
        $file->saveAs($path . DIRECTORY_SEPARATOR . $disk_name);
        $image = new SystemFiles();
        $image->attachment_id = $model->id;
        $image->attachment_type = $model->tableName();
        $image->file_name = $file_name;
        $image->disk_name = $disk_name;
        $image->file_size = $file_size;
        $image->content_type = $content_type;
        return $image;
    }

    public function actionDeleteImg($id_img)
    {
        if (($model = SystemFiles::findOne($id_img)) and $model->delete()) {
            return true;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
