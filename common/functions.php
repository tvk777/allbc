<?php
use yii\helpers\ArrayHelper;

function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

//return true if all values of array is empty
function isEmptyValues($arr)
{
    $flag = true;
    foreach ($arr as $val) {
        if (strlen(trim($val)) > 0) {
            $flag = false;
            break;
        }
    }
    return $flag;
}

//get content for default language if no translate
function getDefaultTranslate($attribute, $suffix, $translates, $notMulti = false)
{
    $att = $attribute . '_' . $suffix;
    if ($notMulti && $suffix == 'ru') return $translates->$attribute;
    if ($translates->$att && $translates->$att != '') {
        $content = $translates->$att;
    } else {
        $content = $translates->$attribute;
    }
    return $content;
}

function getLangInflect($model, $suffix)
{
    switch ($suffix) {
        case 'ru':
            return $model->inflect;
            break;
        case 'ua':
            return $model->inflect_ua;
            break;
        case 'en':
            return $model->name;
            break;
    }
}

/**
 * Checks if a folder exist and return canonicalized absolute pathname (sort version)
 * @param string $folder the path being checked.
 * @return mixed returns the canonicalized absolute pathname on success otherwise FALSE is returned
 */
function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    //return ($path !== false AND is_dir($path)) ? $path : false;
    return is_dir($path) ? $path : false;
}

function FilterAndTrim($arr)
{
    return array_filter($arr, function ($item) {
        return !empty(trim($item));
    });
}

function getUniqueArray($key, $array)
{
    $arrayKeys = array(); // массив для хранения ключей
    $resultArray = array(); // выходной массив
    foreach ($array as $one) { // проходим циклом по всему исходному массиву
        if (!in_array($one[$key], $arrayKeys)) { // если такого значения еще не встречаласть, то
            $arrayKeys[] = $one[$key]; // пишем значение ключа в массив, для дальнейшей проверки
            $resultArray[] = $one; // записываем уникальное значение в выходной массив
        }
    }
    return $resultArray; // возвращаем массив
}

//возвращает true false в зависимости от того есть ли добавочная стоимость к минимальному значению
//на входе принимает массив из BcPlacesView Object - офисов для БЦ
function getPlusForBC($places)
{
    $arr = ArrayHelper::map($places, 'pid', 'uah_price');
    $arrNotNull = array_filter($arr, function ($v) {
        return !empty($v);
    });
    $min = count($arrNotNull) > 0 ? min($arrNotNull) : null;
    foreach ($places as $place) {
        if (!is_null($min) && $place->uah_price === $min) {
            if ($place->kop > 0 || $place->tax == 1 || $place->tax == 5 || $place->opex > 0) {
                return true;
            }
        }
    }
    return false;
}

function getBcMinPrice($item, $currency, $rate)
{
    //$currency=4;
    if (empty($item['bc']->minPrice)) return Yii::t('app', 'price con.');
    $plus = getPlusForBC($item['places']) ? '++' : '';
    $text = getCurrencyText($currency);
    return round($item['bc']->minPrice / $rate) . $plus . ' ' . $text[0];
}

function getBcMinPriceAll($item, $currency, $rate)
{
    //$currency=4;
    if (empty($item['bc']->minPriceAll)) return Yii::t('app', 'price con.');
    $plus = getPlusForBC($item['places']) ? '++' : '';
    $text = getCurrencyText($currency);
    return round($item['bc']->minPriceAll / $rate) . $plus . ' ' . $text[1];
}

function getExtraPriceForBC($places)
{
    $extraPrices = [];
    $extraPrices['plus'] = false;
    $extraPrices['forAll'] = false;
    $arr = ArrayHelper::map($places, 'pid', 'uah_price');
    $arrNotNull = array_filter($arr, function ($v) {
        return !empty($v);
    });
    $min = count($arrNotNull) > 0 ? min($arrNotNull) : null;
    foreach ($places as $place) {
        if (!is_null($min) && $place->uah_price === $min) {
            if ($place->kop > 0 || $place->tax == 1 || $place->tax == 5 || $place->opex > 0) {
                $extraPrices['plus'] = true;
            }
            $extraPrices['forAll'] = round($place->uah_price * $place->m2);
        }
    }
    return $extraPrices;
}

function getBcMinPrices($item, $currency, $rate)
{
    $minPrices = [];
    $extra = getExtraPriceForBC($item['places']);
    if (!$extra['forAll']) {
        $minPrices['forM2'] = $minPrices['forAll'] = Yii::t('app', 'price con.');
    } else {
        $plus = $extra['plus'] ? '++' : '';
        $text = getCurrencyText($currency);
        $minPrices['forM2'] = round($item['bc']->minPrice / $rate) . $plus . ' ' . $text[0];
        $minPrices['forAll'] = round($extra['forAll'] / $rate) . $plus . ' ' . $text[1];
    }
    return $minPrices;
}

function getCurrencyText($currency)
{
    $text = [];
    switch ($currency) {
        case 1:
            $text[0] = Yii::t('app', '&#8372;/m²/month');
            $text[1] = Yii::t('app', '&#8372;/month');
            break;
        case 2:
            $text[0] = Yii::t('app', '$/m²/month');
            $text[1] = Yii::t('app', '$/month');
            break;
        case 3:
            $text[0] = Yii::t('app', '€/m²/month');
            $text[1] = Yii::t('app', '€/month');
            break;
        case 4:
            $text[0] = Yii::t('app', '₽/m²/month');
            $text[1] = Yii::t('app', '₽/month');
            break;
        default:
            $text[0] = Yii::t('app', '&#8372;/m²/month');
            $text[1] = Yii::t('app', '&#8372;/month');
            break;
    }
    return $text;
}


//возвращает true false в зависимости от того есть ли добавочная стоимость к минимальному значению
//на входе принимает массив из BcPlacesView Object - офисов для БЦ
function getPlusForPlace($place)
{
    if ($place->kop > 0 || $place->tax == 1 || $place->tax == 5 || $place->opex > 0) {
        return true;
    }
    return false;
}

//цена с текстом валюты для страницы выдачи офисов
function getPlacePrices($place, $currency, $rates, $taxes)
{
    $prices['forM2'] = Yii::t('app', 'con.');
    $prices['forAll'] = Yii::t('app', 'con.');
    if ($place->con_price != 1 && !empty($place->uah_price)) {
        $text = getCurrencyText($currency);
        $placePlus = getPlusForPlace($place) ? '++' : '';
        $price = round($place->uah_price / $rates[$currency]);
        $prices['forM2'] = $price . $placePlus . ' ' . $text[0];
        $prices['forAll'] = round(calculateRentPrice($place, $taxes, $rates) / $rates[$currency]). ' ' . $text[1];
    }
    return $prices;
}


function getPlacePrice($place, $currency, $rates, $taxes)
{
    $prices['forM2'] = Yii::t('app', 'con.');
    $prices['forAll'] = Yii::t('app', 'con.');
    if ($place->con_price != 1 && !empty($place->uah_price)) {
        $placePlus = getPlusForPlace($place) ? '++' : '';
        $price = round($place->uah_price / $rates[$currency]);
        $prices['forM2'] = $price . $placePlus;
        $prices['forAll'] = round(calculateRentPrice($place, $taxes, $rates) / $rates[$currency]);
    }
    return $prices;
}

//price from bc_places_view
function calculateRentPrice($place, $taxes, $rates)
{
    $plusKop = $place->kop>0 ? ($place->m2 + ($place->m2*$place->kop)/100) : $place->m2;
    $stavkaTax = $place->tax==1 || $place->tax==4
        ? $place->uah_price + ($place->uah_price*$taxes[$place->tax])/100
        : $place->uah_price;
    $opexValuteId = !empty($place->opex_valute_id) ? $place->opex_valute_id : 1;
    $opex_uah = $place->opex * $rates[$opexValuteId];
    $opex = $place->opex_tax==1 || $place->opex_tax==4
        ? $opex_uah + ($opex_uah*$taxes[$place->opex_tax])/100
        : $opex_uah;
    $stavka = $stavkaTax + $opex;

    return $plusKop * $stavka;
}