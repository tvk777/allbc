<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\ErrorException;
use common\models\GeoCities;
use common\models\GeoCountries;
use common\models\GeoDistricts;

/**
 * Login form
 */
class Geo extends Model
{
    protected static $google_api_key = 'AIzaSyAI6Pd1FNzideumlXBpPgvmzEDqyITNlCw';

    static public function getLocationByAddress($address, $lang='ru')
    {

        try {
            $result = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".self::$google_api_key."&language=".$lang);
            //print("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=".self::$google_api_key."&language=".$lang);exit();
            $result = json_decode($result, true);
            //print_R($result);exit();
            if(!isset($result['results'][0]) || $result['status']!='OK')
                throw new ErrorException ("Пустой результат для https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".self::$google_api_key."&language=".$lang);
        }
        catch (ErrorException $ex) {
            Yii::warning("Ошибка геокодирования");
            return(0);
        }

        foreach($result['results'] as $k=>$v)
        {
            if(isset($v['types'][0]) && isset($v['types'][1]) && isset($v['types'][2]))
            {
                if($v['types'][0]=="political" && $v['types'][1]=="sublocality" && $v['types'][2]=="sublocality_level_1")
                {
                    $location['district']['name'] = $v['address_components'][0]['long_name'];
                    $location['district']['place_id'] = $v['place_id'];
                    $location['district']['lat'] = $v['geometry']['location']['lat'];
                    $location['district']['lng'] = $v['geometry']['location']['lng'];
                }
                elseif($v['types'][0]=="political" && $v['types'][1]=="sublocality" && $v['types'][2]=="sublocality_level_2")
                {
                    $location['district_2']['name'] = $v['address_components'][0]['long_name'];
                    $location['district_2']['place_id'] = $v['place_id'];
                    $location['district_2']['lat'] = $v['geometry']['location']['lat'];
                    $location['district_2']['lng'] = $v['geometry']['location']['lng'];
                }
            }
            elseif(isset($v['types'][0]) && isset($v['types'][1]))
            {
                if($v['types'][0]=="country" && $v['types'][1]=="political")
                {
                    $location['country']['name'] = $v['address_components'][0]['long_name'];
                    $location['country']['place_id'] = $v['place_id'];
                    $location['country']['lat'] = $v['geometry']['location']['lat'];
                    $location['country']['lng'] = $v['geometry']['location']['lng'];
                }
                elseif($v['types'][0]=="locality" && $v['types'][1]=="political")
                {
                    $location['city']['name'] = $v['address_components'][0]['long_name'];
                    $location['city']['place_id'] = $v['place_id'];
                    $location['city']['lat'] = $v['geometry']['location']['lat'];
                    $location['city']['lng'] = $v['geometry']['location']['lng'];
                }
            }
            elseif(isset($v['types'][0]))
            {
                if($v['types'][0]=="premise")
                {
                    foreach($v['address_components'] as $k2=>$v2)
                    {
                        if(isset($v2['types'][0]) && $v2['types'][0]=="street_number")
                        {
                            $location['street_number']['name'] = $v2['long_name'];
                            $location['street_number']['place_id'] = $v['place_id'];
                        }
                        elseif(isset($v2['types'][0]) && $v2['types'][0]=="route")
                        {
                            $location['street_name']['name'] = $v2['long_name'];
                            $location['street_name']['place_id'] = $v['place_id'];
                        }
                    }

                }
            }

        }

        if(isset($location['district_2']))
            $location['district'] = $location['district_2'];

        if(!isset($location))
        {
          new ErrorException ("Пустой location для https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".self::$google_api_key."&language=".$lang);
            return(0);
        }

        //  dd($result['results']);
        if(!isset($location['country']))
        {
            foreach($result['results'][0]['address_components'] as $k=>$v)
            {

                if(isset($v['types'][0]) && $v['types'][0]=='country' && isset($v['types'][1]) && $v['types'][1]=="political")
                {
                    $result_country = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$v['short_name']."+".$v['long_name']."&key=".self::$google_api_key."&language=".$lang);
                    $result_country = json_decode($result_country, true);
                    if(isset($result_country['results'][0]['types'][0]) && $result_country['results'][0]['types'][0]=='country' &&
                        isset($result_country['results'][0]['types'][1]) && $result_country['results'][0]['types'][1]=='political'
                        && $result_country['status']!='OK')
                    {

                        $location['country']['name'] = $result_country['results'][0]['address_components'][0]['long_name'];
                        $location['country']['place_id'] = $result_country['results'][0]['place_id'];
                    }
                }
            }
        }


        return($location);


    }

    static function getSubwaysByLatLng($LatLng, $lang="ru")
    {
        //echo "https://maps.googleapis.com/maps/api/place/search/json?language=".$lang."&location=".urlencode($LatLng)."&rankby=distance&type=subway_station&key=".self::$google_api_key;
        try {
            $result = file_get_contents("https://maps.googleapis.com/maps/api/place/search/json?language=".$lang."&location=".urlencode($LatLng)."&rankby=distance&type=subway_station&key=".self::$google_api_key);
            $result = json_decode($result, true);
            if($result['status']!='OK' && $result['status']!='ZERO_RESULTS')
                throw new ErrorException ("Пустой результат для https://maps.googleapis.com/maps/api/place/search/json?language=".$lang."&location=".urlencode($LatLng)."&types=subway_station&key=".self::$google_api_key);
        }
        catch (ErrorException $ex) {
            Yii::warning($ex);
            return(0);
        }

        if(isset($result['results'][0]))
        {
            foreach($result['results'] as $k=>$v)
            {
                $direction = self::getDirection($LatLng, $v['geometry']['location']['lat'].','.$v['geometry']['location']['lng']);
                $subways[] = array('lat'=>$v['geometry']['location']['lat'],'lng'=>$v['geometry']['location']['lng'],'place_id'=>$v['place_id'],'name'=>$v['name'], 'walk_distance' => $direction['walk_distance']);
                if(count($subways)>2)
                    break;
            }

            usort($subways, function ($item1, $item2) {
                return $item1['walk_distance'] <=> $item2['walk_distance'];
            });

            return($subways);
        }
        else
            return(0);

    }

    static function getDirection($place, $place2)
    {
        try {
            $result = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($place)."&destination=".urlencode($place2)."&mode=walking&key=".self::$google_api_key);
            /*echo "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($place)."&destination=".urlencode($place2)."&mode=walking&key=".self::$google_api_key; die();*/
            $result = json_decode($result, true);
            //print_R($result);exit();
            if(($result['status']!='OK' && $result['status']!='ZERO_RESULTS') || !isset($result['routes'][0]))
                throw new ErrorException ("https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$place."&destination=place_id:".$place2."&key=&mode=walking");

            return(array('walk_distance'=>$result['routes'][0]['legs'][0]['distance']['value'],'walk_seconds'=>$result['routes'][0]['legs'][0]['duration']['value']));
        }
        catch (ErrorException $ex) {
            Yii::warning("Ошибка геокодирования");
            return(0);
        }
    }

    static public function getGoogleKey()
    {
        return(self::$google_api_key);
    }

    static public function getUserCity()
    {
        if (Session::has('user_city')) {
            if(City::where('active', 1)->where('bc_count','>',0)->where('id','=',Session::get('user_city'))->get()->count()>0)
                return(Session::get('user_city'));
            else
                return(1);
        }
        else
        {
            return(1);
        }
    }

    static public function setUserCity($city_id)
    {
        Session::put('user_city',$city_id);
    }

    static public function getUserCityInfo()
    {
        $city = City::find(self::getUserCity());
        $city->phone_number_format = preg_replace('/\D/', '', $city->phone);
        return($city);
    }

    static public function getCityValue($value) {
        if(is_numeric($value) && GeoCities::find()->where(['id' => (int)$value])->one())
        {
            return($value);
        }
        $place_info = self::getLocationByAddress($value);
        //debug($place_info); die();
        if(isset($place_info['city']['place_id']))
        {
            $city = GeoCities::find()->where(['place_id' => $place_info['city']['place_id']])->one();
            if(!$city)
            {
                $city = new GeoCities();
                $city->place_id = $place_info['city']['place_id'];
                $city->name = $place_info['city']['name'];
                $city->lat = $place_info['city']['lat'];
                $city->lng = $place_info['city']['lng'];
                $city->active = 1;
                $city->save();
            }
            return($city->id);
        }
        else
        {
            return(0);
        }
    }

    static public function getCountryValue($value) {
        if(is_numeric($value) && GeoCountries::find()->where(['id' => (int)$value])->one())
        {
            return($value);
        }
        $place_info = Geo::getLocationByAddress($value);
        if(isset($place_info['country']['place_id']))
        {
            $country = GeoCountries::find()->where(['place_id' => $place_info['country']['place_id']])->one();
            if(!$country)
            {
                $country = new GeoCountries();
                $country->place_id = $place_info['country']['place_id'];
                $country->name = $place_info['country']['name'];
                $country->lat = $place_info['country']['lat'];
                $country->lng = $place_info['country']['lng'];
                $country->save();
            }
            return($country->id);
        }
        else
        {
            return(0);
        }
    }

    static public function getDistrictValue($value) {

        if(is_numeric($value) && GeoDistricts::find()->where(['id' => (int)$value])->one())
        {
            return($value);
        }
        $place_info = Geo::getLocationByAddress($value);
        //debug($place_info); die();
        if(isset($place_info['city']['place_id']) && isset($place_info['country']['place_id']) && isset($place_info['district']['place_id']))
        {
            $city = GeoCities::find()->where(['place_id' => $place_info['city']['place_id']])->one();
            $country = GeoCountries::find()->where(['place_id' => $place_info['country']['place_id']])->one();
            $district = GeoDistricts::find()->where(['place_id' => $place_info['district']['place_id']])->one();
            if(!$country)
            {
                $country = new GeoCountries();
                $country->place_id = $place_info['country']['place_id'];
                $country->lat = $place_info['country']['lat'];
                $country->lng = $place_info['country']['lng'];
                $country->name = $place_info['country']['name'];
                $country->save();
            }

            if(!$city)
            {
                $city = new GeoCities();
                $city->place_id = $place_info['city']['place_id'];
                $city->name = $place_info['city']['name'];
                $city->lat = $place_info['city']['lat'];
                $city->lng = $place_info['city']['lng'];
                $city->country_id = $country->id;
                $city->active = 1;
                $city->save();
               // debug($city); die();
            }

            if(!$district)
            {
                $district = new GeoDistricts();
                $district->place_id = $place_info['district']['place_id'];
                $district->name = $place_info['district']['name'];
                $district->lat = $place_info['district']['lat'];
                $district->lng = $place_info['district']['lng'];
                $district->city_id = $city->id;
                $district->save();
            }

            return($district->id);
        }
        else
        {
            return(null);
        }
    }

    /*static public function getSubwaysValue($old, $new) {
        //echo count($old);
        if(count($old>0) && count($new)>0) {
            $old_ids = ArrayHelper::getColumn($old, 'subway_id');
            $new_ids = ArrayHelper::getColumn($new, 'subway_id');

            //debug($new_ids); die();
            foreach ($old as $old_v) {
                if(ArrayHelper::isIn($old_v->id, $new_ids)){
                    
                }

            }
        }
    }*/



}
