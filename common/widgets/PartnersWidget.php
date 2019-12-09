<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\SystemFiles;



class PartnersWidget extends Widget{
    public function init()
    {
        parent::init();
    }

    public function run() {
        $models = SystemFiles::find()->where(['attachment_type' => 'partners'])->orderBy('sort_order')->all();
        $images = [];
        foreach($models as $model){
            $name = $model->disk_name;
            $n = explode('.', $name);
            $extension = end($n);
            $dir0 ='/uploads/';
            $dir1 = substr($name, 0, 3).'/';
            $dir2 = substr($name, 3, 3).'/';
            $dir3 = substr($name, 6, 3).'/';
            //$path = $dir0.$dir1.$dir2.$dir3;
            $images[] = $dir0.$dir1.$dir2.$dir3.'thumb_' . $model->id . '.' . $extension;
            //$images[] = $model->disk_name;
        }
        return $this->render('partners',[
            'images' => $images,
        ]);
    }


}