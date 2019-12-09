<?php
use yii\helpers\Html;
$currentLanguage = Yii::$app->language;
?>
				<h2><?= Yii::t('app', 'Reasons to use the service') ?></h2>
				<div class="overflow_wrapp">
                    <div class="thumbnails_1 offset_ziro">
                        <?php foreach($model as $one):?>
                        <div class="thumb_1">
							<div class="icon_box">
								<?= Html::img($one->img->imgSrc, ['alt' => $one->name]) ?>
							</div>
							<h3><?= getDefaultTranslate('name', $currentLanguage,$one) ?></h3>
							<p><?= getDefaultTranslate('text', $currentLanguage,$one) ?></p>
                        </div>
                        <?php endforeach; ?>

					</div>
				</div>
