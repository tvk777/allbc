<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\BcSlider;



class MainSliderWidget extends Widget{

    public function init()
    {
        parent::init();
    }

    public function run() {

        $model = BcSlider::find()->where(['or', 'slider_id=1', 'slider_id=2'])->with('bcitem.images','bcitem.slug')->all(); //для слайдера на главной
        $images = [];
        foreach($model as $index => $one){
            $bc = $one->bcitem;
            $img = $bc->images[0];
            $images[$index]['url'] = $img->imgSrc;
            $images[$index]['href'] = $bc->slug->slug; //для слайдера на главной
            $images[$index]['title'] = getDefaultTranslate('name', Yii::$app->language, $bc);//для слайдера на главной
        }

        return $this->render('main-slider',[
            'images' => $images,
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