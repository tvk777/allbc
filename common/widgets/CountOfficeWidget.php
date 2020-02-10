<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\GeoCities;
use yii\helpers\Url;


class CountOfficeWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $cities = GeoCities::find()->where(['active' => 1])->andWhere(['>', 'bc_count', 0])->orderBy('sort_order')->all();
        $result = (strpos(Url::current(),'filter[result]=offices')) ? '?filter[result]=offices' : '';
        return $this->render('count-office', [
            'cities' => $cities,
            'result' => $result
        ]);
    }


}