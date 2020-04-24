<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\BcSlider;



class SliderWidget extends Widget{
    public $text = null;

    public function init()
    {
        parent::init();
    }

    public function run() {

        $model = BcSlider::find()->where(['or', 'slider_id=1', 'slider_id=3'])->with('bcitem.images')->all(); //для слайдера на главной
        $images = [];
        foreach($model as $index => $one){
            $bc = $one->bcitem;
            $img = $bc->images[0];
            $images[$index]['url'] = $img->imgSrc;
        }

        $imgs='';
        return $this->render('slider',[
            'images' => $images,
            'text' => $this->text,
            'class' => 'promo-slider-bc'
        ]);
}


}




/*$slides = SystemFiles::find()->where(['attachment_type' => 'slide'])->orderBy('sort_order')->all();
$images = [];
if (!empty($slides)) {
    foreach ($slides as $index => $slide) {
        $images[$index]['url'] = $slide->imgSrc;
        $images[$index]['href'] = $slide->description;
        $images[$index]['title'] = $slide->title;
    }
} else {
    $images[0]['url'] = '/img/promo_bg.jpg';
    $images[0]['href'] = '#';
    $images[0]['title'] = '';
}*/