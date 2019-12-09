<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use common\models\SystemFiles;
use common\models\TempImages;
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

            /*SystemFiles::updateAll([
                'attachment_id' => $model->id,
            ], ['=', 'attachment_id', $model->tmpid]);*/

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
        $this->createTempTable();
        $this->fillingTempTable($model);
        //$model->attachment = UploadedFile::getInstances($model, 'attachment');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // debug();
            //return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function createTempTable()
    {
        $create = 'CREATE TABLE  IF NOT EXISTS `temp_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `disk_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` int(11) NOT NULL,
  `content_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `sort_order` int(11) DEFAULT NULL)';
        Yii::$app->db->createCommand($create)->execute();
    }

    public function fillingTempTable($model)
    {
        $images = $model->images;
        foreach ($images as $img) {
            $tmpmodel = new TempImages();
            $tmpmodel->disk_name = $img->disk_name;
            $tmpmodel->file_name = $img->file_name;
            $tmpmodel->file_size = $img->file_size;
            $tmpmodel->content_type = $img->content_type;
            $tmpmodel->title = $img->title;
            $tmpmodel->description = $img->description;
            $tmpmodel->sort_order = $img->sort_order;
            $tmpmodel->save();
        }
    }


    /*public function fillingTempTable($model){
        //debug($model->images); die();
        $images = $model->images;
        $count = count($images);
        $k=0;
        $insert = 'INSERT INTO `temp_images` (`disk_name`, `file_name`, `file_size`, `content_type`, `title`, `description`, `sort_order`) VALUES ';
        foreach ($images as $img){
            $k++;
            $sort_order = ($img->sort_order && $img->sort_order!=NULL && $img->sort_order!='') ? $img->sort_order : 'NULL';
            $insert .= '("'.$img->disk_name.'", ';
            $insert .= '"'.$img->file_name.'", ';
            $insert .= $img->file_size.', ';
            $insert .= '"'.$img->content_type.'", ';
            $insert .= '"'.$img->title.'", ';
            $insert .= '"'.$img->description.'", ';
            if($k==$count){
                $insert .= $sort_order.'); ';
            } else{
                $insert .= $sort_order.'), ';
            }
        }
        Yii::$app->db->createCommand($insert)->execute();
    }*/

    public function actionUploadImages()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
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
