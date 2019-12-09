<?php

namespace backend\controllers;

use common\models\Slugs;
use Yii;
use common\models\Services;
use common\models\ServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SystemFiles;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
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
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//debug($dataProvider); die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
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
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();
        $slug = new Slugs();
        $model->enable = 1;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $file = UploadedFile::getInstance($model, 'upload_image');
                if (!empty($file) && $file->size !== 0) {
                    $image = $this->saveImage($file, $model);
                    if ($image->save()) {
                        return $this->redirect(['index']);
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
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->alias = $model->slug->slug;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $file = UploadedFile::getInstance($model, 'upload_image');
            if (!empty($file) && $file->size !== 0) {
                if ($model->img) {
                    $model->img->delete();
                }
                $image = $this->saveImage($file, $model);
                if ($image->save()) {
                    return $this->redirect(['index']);
                }
            } else {
                if (!$model->img) {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'need image'));
                    return $this->render('update', ['model' => $model,]);
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Services model.
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
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = Services::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
