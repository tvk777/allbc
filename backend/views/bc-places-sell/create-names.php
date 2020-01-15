<?php

use yii\helpers\Html;
use common\models\Slugs;

/* @var $this yii\web\View */
/* @var $model common\models\BcPlaces */

$this->title = Yii::t('app', 'Create Bc Places H1 & Names');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-places-create">

    <h1><?= Html::encode($this->title) ?></h1>
ready
    <?
    /*foreach($model as $place){
        $slug = 'arenda-ofica-'.$place->m2.'-m2-'.$place->bcitem->city->name.'-id'.$place->id;
        $alias = Slugs::generateSlug('bc_places', $place->id, $slug);
        echo $alias.'<br>';
        //Slugs::initialize('bc_places', $place->id, $alias);
    }*/
    //debug($model);
    foreach($model as $place){
        $name = $place->createName();
        $place->name = $name['ru'];
        $place->name_ua = $name['ua'];
        $place->name_en = $name['en'];
        $place->showm2 = $place->m2range;
        if(!$place->save()) debug($place->getErrors());
    }
    ?>

</div>
