<?php

namespace frontend\controllers;
use Yii;
use common\models\Post;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //$posts = Post::find()->all();

        $posts = Post::find()->multilingual()->all();

       return $this->render('index', compact('posts'));
    }

    public function actionView($url)
    {
        $model = new Post();
        //пост соответствующий переданному url
        //$post = $model->getPost($url);
        //данные поста из связанной таблицы lang_post
        //$lang_data = $post->getDataPosts();

        /*return $this->render('view', [
            'post' => $post,
            'lang_data' => $lang_data,
        ]);*/
    }

}
