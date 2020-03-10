<?php
use yii\helpers\Html;

$currentLanguage = Yii::$app->language;
?>

<div class="col">
    <?= getDefaultTranslate('content', $currentLanguage, $text) ?>
</div>

<div class="col">
    <div class="seotext_wrapp clearfix">
        <?php foreach ($menu as $key => $coll): ?>
            <?php
            switch ($key) {
                case 1:
                    $title = Yii::t('app', 'Company');
                    break;
                case 2:
                    $title = Yii::t('app', 'Information');
                    break;
                case 3:
                    $title = Yii::t('app', 'Offices');
                    break;
            }
            ?>
            <div class="seotext">
                <h4><?= $title ?></h4>
                <ul>
                    <?php foreach ($coll as $item): ?>
                        <?php $text = getDefaultTranslate('text', $currentLanguage, $item); ?>
                        <li><?= Html::a($text, [$item->url]) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="col">
    <ul class="socilals">
        <li><a href="#"><img src="/img/instagram.svg" alt="" /></a></li>
        <li><a href="#"><img src="/img/youtube.svg" alt="" /></a></li>
        <li><a href="#"><img src="/img/facebook.svg" alt="" /></a></li>
    </ul>
    <div class="contacts_wrapp">
        <p><a href="tel:+380670088200" class="tel_link">+380(67)00-882-00</a></p>
        <p>
            <?= Html::a(
                Yii::t('app', 'Mail to support'),
                ['/support'],
                ['class' => 'transparent_pill_2 modal-form size-middle']
            ) ?>
        </p>
    </div>
</div>


			
