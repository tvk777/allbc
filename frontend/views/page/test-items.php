<?php
use yii\helpers\ArrayHelper;
debug($test['markers']);
debug(ArrayHelper::getColumn($test['places_for_charts'], 'id'));
echo count($test['bcItems']);
//debug($test);

foreach($test as $item){
    //debug($item['id']);
}

?>
