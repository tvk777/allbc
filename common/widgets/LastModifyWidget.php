<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\BcItems;
use common\models\BcPlaces;
use yii\helpers\ArrayHelper;



class LastModifyWidget extends Widget{

    public function run() {
        $places = BcPlaces::find()->where(['archive' => 0])->asArray()->andWhere(['hide' => 0])->all();
        $placesIds = ArrayHelper::getColumn($places, 'item_id');

        $items = BcItems::find()
            ->with('places','images','class', 'city', 'slug')
            ->where(['active' => 1])
            ->andWhere(['approved' => 1])
            ->andWhere(['in', 'id', $placesIds])
            ->orderBy('updated_at DESC')
            ->multilingual()
            ->limit(10)
            ->all();
        return $this->render('last-modify',[
            'model' => $items,
        ]);
    }


}