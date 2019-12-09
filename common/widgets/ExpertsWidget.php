<?php
namespace common\widgets;

use common\models\Experts;
use Yii;
use yii\base\Widget;
use common\models\Texts;
use common\models\GeoCities;



class ExpertsWidget extends Widget{

    public function run() {
        $text = Texts::find()->where(['id' => 4])->multilingual()->one();
        $experts = Experts::find()->where(['active' => 1])->with('user.avatar')->orderBy('sort_order')->all();
        //select Kiev for slug
        $city = GeoCities::find(1)->one();
        $baseUrl = '/'.$city->slug;

        return $this->render('experts',[
            'experts' => $experts,
            'text' => $text,
            'baseUrl' =>$baseUrl
        ]);
    }


}