<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;



class CurrencyWidget extends Widget{
    public function run() {
        return $this->render('currency');
    }
}