<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\Texts;



class AboutUsWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        return $this->render('about-us',[
            'model' => Texts::find()->where(['id' => 2])->multilingual()->one()
        ]);
    }


}