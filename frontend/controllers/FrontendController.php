<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class FrontendController extends Controller
{
    public $result = 'bc';

    /*public function beforeAction($action)
    {
        $this->result = Yii::$app->request->get('result') ? Yii::$app->request->get('result') : 'bc';
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }*/

}