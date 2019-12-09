<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Tabs;



class MultiLangTabsWidget extends Widget
{
    public $attributes;
    public $model;
    public $form;

    public function init()
    {
        parent::init();
        if ($this->attributes === null) {
            $this->attributes = 'name';
        }
    }

    public function run()
    {
        $langs = Yii::$app->params['languages']; //['ru', 'ua', 'en'];
        $items=[];
        $active = true;
        foreach($langs as $k=>$lang){
            if($k>0) $active = false;
            $items[] = [
                'label' => $lang,
                'content' => $this->render('multilang/lang_form',
                    [
                        'lang' => $lang,
                        'model' => $this->model,
                        'attributes' => $this->attributes,
                        'form' => $this->form
                    ]),
                'active' => $active // указывает на активность вкладки
            ];

        }


        return Tabs::widget([
            'items' => $items
        ]);
    }


}