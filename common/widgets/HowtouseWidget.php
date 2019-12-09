<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\InfoblocksHowtouse;



class HowtouseWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        return $this->render('howtouse',[
            'model' => InfoblocksHowtouse::find()->with('img')->multilingual()->all(),
        ]);
    }


}