<?php
use yii\helpers\Html;
$currentLanguage = Yii::$app->language;
?>

<h2><?= Yii::t('app', 'Reviews') ?></h2>
<div class="testimonial_slider_contorls"></div>
<div class="thumbnails_2 slider_partners_2 reviews">
    <?php foreach ($logos as $logo): ?>
        <a href="#" class="thumb_2" data-id="<?= $logo['id'] ?>">
            <?= Html::img($logo['img'], ['alt' => '']) ?>
        </a>
    <?php endforeach; ?>
</div>
<div class="testimonial_slider_wrapp">
    <div class="testimonial_slider">
        <?php foreach ($models as $model): ?>
            <div data-id="<?= $model->id ?>">
                <div class="slide">
                    <div class="testimonila_wrapp">
                        <div class="descript">
                            <?= getDefaultTranslate('text', $currentLanguage, $model) ?>
                            <div class="author">
                                <h5><?= getDefaultTranslate('name', $currentLanguage, $model) ?>, <span><?= getDefaultTranslate('position', $currentLanguage, $model) ?></span></h5>
                            </div>
                        </div>
                        <?
                        if(!empty($model->video)) {
                            $href = $model->video;
                            $video_id = explode('v=', $model->video);
                            $thumb = '//img.youtube.com/vi/'.end($video_id).'/sddefault.jpg';
                            $play = '<i class="play"></i>';
                            //$thumb = <img src="//img.youtube.com/vi/JMJXvsCLu6s/sddefault.jpg" width="640" height="480">
                        } else {
                            $play = '';
                            if(!empty($model->image)){
                                $href = $model->image->imgSrc;
                                $thumb = $model->image->thumbSrc;
                            }
                        }

                        /*$href = !empty($model->video) ? $model->video : $model->image->imgSrc;
                        $thumb = !empty($model->image) ? $model->image->thumbSrc : '';*/
                        ?>
                        <a href="<?= $href ?>" class="img_box" data-fancybox>
                            <?= Html::img($thumb, ['alt' => '']) ?>
                            <?= $play ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
