<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\Texts;



class MainTitleWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $title = Texts::find()->where(['id' => 1])->multilingual()->one();
        
        return $this->render('main-title',[
            'title' => $title,
        ]);
    }


}