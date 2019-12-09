<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\Services;



class ServicesWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        return $this->render('services',[
            'model' => Services::find()->with('img','slug')->where(['enable' => 1])->orderBy('sort_order')->multilingual()->all(),
        ]);
    }


}