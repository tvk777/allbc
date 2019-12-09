<?php

namespace backend\controllers;

use common\models\LangPost;
use Yii;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->with('defaultLangPosts')  //->with('defaultLangPosts') ->joinWith(['defaultLangPosts'])
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            //'posts' => $posts
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $languages = Yii::$app->getModule('languages')->languages;
        $model = $this->findModel($id);
        
        //$lang_posts - данные для всех языковых версий сайта
        $lang_posts = [];
        foreach($languages as $lang){
            if($model->LangPost($id, $lang)) {
                $lang_posts[$lang] = $model->LangPost($id, $lang);
                //$lang_posts[$lang]->charakteristics = json_decode($lang_posts[$lang]->charakteristics, true);
            } else {
                $lang_posts[$lang] = new LangPost();
            }
        }
    //debug(Yii::$app->request->post('LangPost'));   die();

        //$model->test = json_decode($model->test, true);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /*if(Yii::$app->request->post('Post')['test']){
              $model->test = json_encode(Yii::$app->request->post('Post')['test']);
            }*/

            if($LangPost = Yii::$app->request->post('LangPost')){
                foreach($LangPost as $key => $data){
                    //debug($data['id']); die();
                    if($data['id']){
                        $lang_model = LangPost::findOne($data['id']);
                        //debug($lang_model); die();
                    }
                    else {
                        if(!isEmptyValues($data)) {
                            $lang_model = new LangPost;
                        }
                    }
                    //debug($lang_model); die();
                    $lang_model->title = $data['title'];
                    $lang_model->text = $data['text'];
                    $lang_model->post_id = $id;
                    $lang_model->lang = $key;
                    $lang_model->save();
                }
            }


           return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
            'lang_posts' => $lang_posts,
        ]);
    }

    public function actionTest()
    {
        //return json_encode([['value' => 'aaa'], ['value' => '"bbb"']]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = ['some', 'array', 'of', 'data' => ['associative', 'array']];
        return $items;
    }

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
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
