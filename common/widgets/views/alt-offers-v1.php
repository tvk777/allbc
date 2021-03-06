<?php
use yii\helpers\Html;
use yii\helpers\Url;
//$url = Url::toRoute(['product/view', 'id' => 42]);
//Url::to(['page/services', 'slug' =>$one->slug->slug]
$currentLanguage = Yii::$app->language;
?>
<h2><?= Yii::t('app', 'Alternative Offers') ?></h2>
<div class="slider_alt_wrapp">
    <div class="slider_controls_wrapp">
        <div class="col">
            <div class="slider_controls slider_alt_controls"></div>
        </div>
    </div>
    <div class="slider_alt">
        <?php foreach ($items as $one): ?>
            <?php
            $minmax = $one->getMinMaxM2($one->places);
            $minmax = is_array($minmax) ? $minmax['min'] . ' m² ...' . $minmax['max'] . ' m²' : $minmax . ' m²';
            $minPrice = $one->getMinPrice($one->places)['price'];
            $minPrice = $minPrice ? $minPrice . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
            $src = !empty($one->images) ? $one->images[0]->thumb300x200Src : '';
            $href = Url::to(['page/bc_item', 'slug' => $one->slug->slug, 'target' => 'rent']);
            ?>
            <div class="slide">
                <a href="<?= $href ?>" class="thumb_5">
                    <div class="thumb_5_img_box">
                        <img src="<?= $src ?>" alt="" />
                        <div class="black_circle">
                            <i class="star_icon"></i>
                        </div>
                    </div>
                    <div class="thumb_descript">
                        <div class="thumb_descript_inner">
                            <div class="two_cols_2">
                                <div class="two_cols_2_col">
                                    <h3><?= getDefaultTranslate('name', $currentLanguage, $one) ?></h3>
                                </div>
                                <div class="two_cols_2_col">
                                    <div class="office_cont">
                                        <div class="col">
                                            <i class="room"></i>
                                        </div>
                                        <div class="col">
                                            <h5><?= count($one->places) ?></h5>
                                            <p><?= Yii::t('app', 'offices') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="two_cols_2 two_cols_2_2">
                                <div class="two_cols_2_col">
                                    <p><?= $one->street ?></p>
                                </div>
                                <div class="two_cols_2_col align_right">
                                    <div class="green_circle">
                                        <p><?= $one->class->short_name ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="thumb_5_footer last-modify">
                            <div class="thumb_5_footer_col">
                                <p><?= $minPrice ?></p>
                            </div>
                            <div class="thumb_5_footer_col">
                                <p><?= $minmax ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


