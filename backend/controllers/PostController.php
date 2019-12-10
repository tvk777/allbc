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
                return $this->redirect(['index']);
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
        if ($model->load(Yii::$app->request->post())  && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model,]);
    }

    public function actionUploadImage($allwoedFiles = NULL)
    {
        
        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstancesByName('Images[attachment]');
            if (empty($file)) exit;
            $file = $file[0];
            return SystemFiles::uploadImage($file,$allwoedFiles);
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

    public function actionSortImage($id)
    {
        if(Yii::$app->request->isAjax){
            SystemFiles::sortImage($id);
            return true;
        }
        throw new MethodNotAllowedHttpException();
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