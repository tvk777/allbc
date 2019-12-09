<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use common\models\DistrictsStat;
use common\models\GeoDistricts;
use yii\helpers\ArrayHelper;



class DistrictsStatWidget extends Widget{
    public $city = 0;
    public $target = 1;


    public function run() {
        //echo $this->city;
        if($this->city!=0){
            $query = DistrictsStat::find();
            if($this->target==1){
                $query->select(['id', 'district_id', 'total_m2', 'count  as count', 'price as price', 'free_m2 as free_m2']);
            } else{
                $query->select(['id', 'district_id', 'total_m2', 'count_sell  as count', 'price_sell as price', 'free_sell_m2 as free_m2']);
            }
            $districtsId = ArrayHelper::getColumn(GeoDistricts::find()->select('id')->where(['city_id'=> $this->city])->asArray()->all(), 'id');
            $districts = $query->where(['in', 'district_id', $districtsId])->with('district.city')->all();
        } else{
            $query = DistrictsStat::find();
            if($this->target==1){
                $query->select(['id', 'district_id', 'total_m2', 'count  as count', 'price as price', 'free_m2 as free_m2']);
            } else{
                $query->select(['id', 'district_id', 'total_m2', 'count_sell  as count', 'price_sell as price', 'free_sell_m2 as free_m2']);
            }
            $districts = $query->with('district.city')->all();
        }
        $sum = $this->target==1 ? $query->sum('count') : $query->sum('count_sell');

        return $this->render('district-stats',[
            'districts' => $districts,
            'target' => $this->target,
            'sum' => $sum
        ]);
    }


}