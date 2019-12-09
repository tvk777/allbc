<?php
use yii\helpers\Html;
use yii\helpers\Url;

//debug($districts);
$currentLanguage = Yii::$app->language;
$middleTitle = $target==1 ? Yii::t('app', 'Average rental') : Yii::t('app', 'Average sale');
?>
<? if($sum>0) : ?>
<h2><?= Yii::t('app', 'District statistics') ?></h2>
<div class="table_slider_wrapp">
    <div class="table_slider_controls"></div>
    <div class="table_slider">
        <div class="slide">
            <div class="overflow_y">
                <div class="static_table">
                    <div class="table_row">
                        <div class="table_cell">
                            <h4><?= Yii::t('app', 'District') ?></h4>
                        </div>
                        <div class="table_cell">
                            <h4><?= $middleTitle ?> m<span class="sq">2</span></h4>
                        </div>
                        <div class="table_cell">
                            <h4><?= Yii::t('app', 'Number of offers') ?></h4>
                        </div>
                        <div class="table_cell">
                            <h4><?= Yii::t('app', 'Vacancy') ?></h4>
                        </div>
                    </div>

                    <?php foreach ($districts as $one): ?>
                        <?php if ($one->count > 0 && $one->district->place_id) : ?>
                            <?
                            $city_url = $target == 2 ? $one->district->city['slug_sell'] : $one->district->city['slug'];
                            $price = $one->price ? $one->price. ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
                            ?>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a target="_blank" href="<? echo $city_url.'?filter[districts][]='.$one->district->id ?>" class="green_link_2"><?= $one->district->name ?></a></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $price ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $one->count ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $one->vacancy ?>%</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? endif; ?>