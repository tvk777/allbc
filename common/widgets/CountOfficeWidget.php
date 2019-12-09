<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\GeoCities;



class CountOfficeWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $cities = GeoCities::find()->where(['active' => 1])->andWhere(['>','bc_count', 0])->orderBy('sort_order')->all();
        
        return $this->render('count-office',[
            'cities' => $cities,
        ]);
    }


}