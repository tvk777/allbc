<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use common\models\BcItems;
use common\models\BcValutes;



class AltOffersWidget extends Widget{
    public $item;
    public $target;
    public $result = 'bc';


    public function run() {
        $m2 = [];
        $lat = $this->item->lat;
        $lng = $this->item->lng;

        $query = BcItems::find()->select('*,  SQRT(POW(69.1 * (`lat` - '.$lat.'), 2) + POW(69.1 * ('.$lng.' - `lng`) * COS(`lat` / 57.3), 2)) AS `distance`');

        if($this->target==1){
            $places = BcPlaces::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
            $query->with('slug', 'places', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'places.images', 'places.stageImg', 'places.prices');
        } else {
            $places = BcPlacesSell::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
            $query->with('slug', 'placesSell', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'placesSell.images', 'placesSell.stageImg', 'placesSell.prices');
        }
        $places = $places->asArray()->all();
        $placesIds = array_unique(ArrayHelper::getColumn($places, 'item_id'));
        $query->where(['<>', 'id', $this->item->id]);
        $query->andWhere(['city_id' => $this->item->city_id]);
        $query->andWhere(['active' => 1]);
        $query->andWhere(['approved' => 1]);
        $query->andWhere(['in', 'id', $placesIds]);
        if($this->result === 'bc'){
            $query->andWhere(['single_office' => 0]);
        }
        $query->orderBy('distance ASC')->limit(12);
        $items = $query->all();

        //фильтрация площадей по выбранным items.
        $itemsIds = ArrayHelper::getColumn($items, 'id');
        foreach ($places as $key => $place) {
            if (!ArrayHelper::isIn($place['item_id'], $itemsIds)) unset($places[$key]);
        }
        $rates = BcValutes::find()->select(['id', 'rate'])->asArray()->all();
        $rates = ArrayHelper::getColumn(ArrayHelper::index($rates, 'id'), 'rate');

//debug($places);
        return $this->render('alt-offers',[
            'items' => $items,
            'm2' => $m2,
            'target' => $this->target,
            'result' => $this->result,
            'places' => $places,
            'rates' => $rates
        ]);
    }


}