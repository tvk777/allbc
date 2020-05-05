<?php
use yii\helpers\ArrayHelper;
//echo 'Запрос1- ' . $time1 . ' секунд</br>';
//echo 'Query2- ' . $time2 . ' секунд</br>';
//echo 'Total- ' . $time3 . ' секунд</br>';
//echo count($items);
//debug(count($fullQuery));
//debug(ArrayHelper::map($items[0]['places'], 'pid', 'uah_price'));
$arr = ArrayHelper::map($items[28]['places'], 'pid', 'uah_price');
debug($items[28]['bc']);
//$min = min($arr);
$min = min(array_filter($arr, function ($v) { return !empty($v); }));
debug(array_keys($arr, min(array_filter($arr, function ($v) { return !empty($v); }))));
foreach($items[28]['places'] as $place){
    if($place->uah_price === $min){
        if($place->kop>0 || $place->tax==1 || $place->tax==5 || $place->opex>0){
          echo 'plus '.$place->id.' - '.$place->pid.'</br>';
        } else {
            echo 'not plus '.$place->id.' - '.$place->pid.'</br>';
        }
    }
}
//debug($bcItemsWithPlaces[0]['bcitem']['slug']['slug']);
//debug($bcItemsWithPlaces);
/*foreach($places as $one){
   debug($one['bc']->bcitem->id);
    debug(count($one['places']));
    foreach ($one['places'] as $place){
        debug($place->place->id);
    }
}*/


foreach($items as $item){
    //echo $item['bc']->minPrice;
    if(getPlusForBC($item['places'])){
        echo $item['bc']->minPrice.'-'.$item['bc']->id.' - +++</br>';
    }
    else {
        echo $item['bc']->id.' - ---</br>';

    }
}

/*foreach($items[1]['places'] as $place){
    if(getPlusForPlace($place)){
        echo $place->pid.' - +++</br>';
    }
    else {
        echo $place->pid.' - ---</br>';

    }
}*/



?>


