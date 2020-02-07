<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use common\models\BcItems;



class AltOffersWidget extends Widget{
    public $item;
    public $target;


    public function run() {
        //debug($this->item->className()); die();
        $m2 = [];
        if($this->item->className()=='common\models\Offices'){
            $lat = $this->target==1 ? $this->item->place->lat : $this->item->placesell->lat;
            $lng = $this->target==1 ? $this->item->place->lng : $this->item->placesell->lng;
        } else {
            $lat = $this->item->lat;
            $lng = $this->item->lng;
        }

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
        $query->multilingual()->orderBy('distance ASC')->limit(12);
        $items = $query->all();

        //фильтрация площадей по выбранным items.
        $itemsIds = ArrayHelper::getColumn($items, 'id');
        foreach ($places as $key => $place) {
            if (!ArrayHelper::isIn($place['item_id'], $itemsIds)) unset($places[$key]);
        }
//debug($places);
        return $this->render('alt-offers',[
            'items' => $items,
            'm2' => $m2,
            'target' => $this->target,
            'places' => $places
        ]);
    }


}