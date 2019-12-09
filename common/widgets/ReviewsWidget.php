<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\Reviews;



class ReviewsWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $models = Reviews::find()->where(['is_public' => 1])->with('image', 'logo')->orderBy('sort_order')->multilingual()->all();
        $logos = [];
        foreach($models as $index => $model){
            $logos[$index]['img'] = !empty($model->logo) ? $model->logo->thumbSrc : '';
            $logos[$index]['id'] = $model->id;
        }
        return $this->render('reviews',[
            'models' => $models,
            'logos' => $logos,
        ]);
    }


}