<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\News;



class NewsWidget extends Widget{
    public function run() {
        return $this->render('news',[
            'model' => News::find()
                ->where(['enable' => 1])
                ->with('slug', 'image')
                ->multilingual()
                ->limit(10)
                ->all()
        ]);
    }


}