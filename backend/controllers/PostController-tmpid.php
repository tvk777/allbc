<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use common\models\SystemFiles;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use Imagine\Image\Point;
use yii\helpers\Html;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //delete tmp images if exist
        if (SystemFiles::find()->where(['=', 'attachment_type', 'post'])->andWhere(['LIKE', 'attachment_id', 'post'])->count() > 0) {
            SystemFiles::deleteAll([
                'AND',
                ['=', 'attachment_type', 'post'],
                ['LIKE', 'attachment_id', 'post'],
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->enabled = 1;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            SystemFiles::updateAll([
                'attachment_id' => $model->id,
            ], ['=', 'attachment_id', $model->tmpid]);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
		//$model->attachment = UploadedFile::getInstances($model, 'attachment');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
			//return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function actionUploadImages()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
			//debug($file); die();
            //$file = UploadedFile::getInstancesByName('Post[attachment]');
			$disk_name = SystemFiles::getDiskName($file[0]);
            $path = Yii::getAlias('@uploads') . '/' . SystemFiles::getPartitionDirectory($disk_name);
            FileHelper::createDirectory($path);
            if ($file[0]->saveAs($path . DIRECTORY_SEPARATOR . $disk_name)) {
                $image = new SystemFiles();
                $image->attachment_id = Yii::$app->request->post('attachment_id');
                $image->attachment_type = Yii::$app->request->post('attachment_type');
                $image->file_name = $file[0]->name;
                $image->disk_name = $disk_name;
                $image->file_size = $file[0]->size;
                $image->content_type = $file[0]->type;
                $image->field = 'post_img';
                if ($image->save()) {
                    $preview[] = Html::a(Html::img($image->imgSrc), ['/bc-places/update', 'id' => $image->id], ['class' => 'modal-form']);
                    $config[] = [
                        'caption' => $image->file_name,
                        'key' => $image->id,
                    ];
                    $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config];
                    return json_encode($out);
                }
            } else {
                return 'Изображение не удалось загрузить';
            }
        }
        return 'Изображение не удалось загрузить';
    }

    public function actionDeleteImg()
    {
        return true;
		//debug(json_decode($post)); die();
		
		/*if (($model = SystemFiles::findOne(Yii::$app->request->post('key'))) and $model->delete()) {
            return true;
        } else {
            throw new NotFoundHttpException('Изображение не удалено');
        }*/
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderPartial($view, $params);
        }
        return parent::render($view, $params);
    }*/
}
