<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\Menu;
use common\models\Texts;



class TopMenuWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $menu = Menu::findTopMenu();

        return $this->render('top-menu',[
            'menu' => $menu
        ]);
}


}