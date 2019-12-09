<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\Menu;
use common\models\Texts;



class FootMenuWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $menu = Menu::findByColl();
        $text = Texts::find()->where(['id' => 3])->multilingual()->one();

        return $this->render('foot-menu',compact('menu', 'text'));
}


}