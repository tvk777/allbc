<?php

namespace common\models;

use Yii;

class BcPlacesView extends \yii\db\ActiveRecord
{
    public $minPrice;
    public $maxPrice;
    public $minM2;
    public $maxM2;
    public $minPriceAll;

    public static function tableName()
    {
        return 'bc_places_view';
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'id'])->with('slug');
    }
    public function getPlace()
    {
        return $this->hasOne(BcPlaces::className(), ['id' => 'pid'])
            ->with('bcitem', 'bcitem.images', 'bcitem.class', 'bcitem.subways', 'bcitem.subways.subwayDetails', 'bcitem.district', 'bcitem.city', 'slug');
    }

}
