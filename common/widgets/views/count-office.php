<?php
$currentLanguage = Yii::$app->language;
//debug($cities[0]);
$kiev_name = $currentLanguage=='ru' ? $cities[0]->name : getDefaultTranslate('name', $currentLanguage, $cities[0]);
?>
<div class="top_menu">
    <div class="dropdowm_wrapp choose-city">
        <div class="dropdown_title">
            <p class="choose-city p_width"><?= $kiev_name ?></p>
            <input type="text" name="" placeholder="<?= Yii::t('app', 'Choose a city')?>" readonly/>
        </div>
        <div class="dropdown_menu">
            <ul>
                <?php foreach ($cities as $k => $city) : ?>
                    <?php if($k==0){$class= 'class="active"';} else {$class='';} ?>
                    <?php
                    switch ($currentLanguage){
                        case 'ru':
                            $name = $city->name;
                            $inflect = $city->inflect;
                            break;
                        case 'ua':
                            $name = getDefaultTranslate('name', $currentLanguage, $city);
                            $inflect = getDefaultTranslate('inflect', $currentLanguage, $city);
                            break;
                        case 'en':
                            $name = getDefaultTranslate('name', $currentLanguage, $city);
                            $inflect = $name;
                    }
                    ?>
                    <li><a data-id="<?= $city->id ?>" data-value="<?= $city->slug.$result ?>" data-valuesell="<?= $city->slug_sell.$result ?>" data-count="<?= $city->bc_count ?>" data-inflect="<?= $inflect ?>" href="#" <?= $class ?>/><?= $name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>


