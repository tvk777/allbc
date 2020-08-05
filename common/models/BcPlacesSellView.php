<?php

namespace common\models;

use Yii;

class BcPlacesSellView extends \yii\db\ActiveRecord
{
    public $minPrice;
    public $maxPrice;
    public $minM2;
    public $maxM2;

    public static function tableName()
    {
        return 'bc_places_sell_view';
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'id'])->with('slug');
    }

    public function getPlace()
    {
        return $this->hasOne(BcPlacesSell::className(), ['id' => 'pid'])
            ->with('bcitem', 'bcitem.images', 'bcitem.class', 'bcitem.subways', 'bcitem.subways.subwayDetails', 'bcitem.district', 'bcitem.city', 'slug');
    }

}
