<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\typeahead\Typeahead;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

//echo 'result='.Yii::$app->controller->result;
AppAsset::register($this);
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$changeCurrency = ($action == 'bc_items' || $action == 'bc_places' || $action == 'bc_places_sell') ? true : false;
//echo $controller.' - '.$action;
//page - bc_items, page - bc_places
if ($controller == 'site' && $action != 'index') {
    $bodyClass = 'class="' . $controller . ' ' . $action . ' pages"';
} else {
    $bodyClass = 'class="' . $controller . ' ' . $action . '"';
}
$headerClass = 'header_site ';
$logoClass = '';
//$logoText = '<span class="logo-text">'.Yii::t('app', 'All business centers here').'</span>';
$logoImg = Html::img('@web/img/logo.svg', ['alt' => 'Логотип']);
$searchIconClass = 'search_icon';
$dropdowmClass = '';
$dropdowmClass2 = '';
$contentClass = '';
$blackClass = '';
$mainNavClass ='';
if ($action == 'index'){
    $headerClass .= 'header_main';
    $mainNavClass = 'main_nav_wrapp_main';
} else {
    $headerClass .= 'header_site_inner header_1';
    $logoClass = 'logo_wrapp_2';
    $logoImg = Html::a(Html::img('@web/img/logo_2.svg', ['alt' => 'Логотип', 'class' => 'logo_black']), [Url::home()]);
    $dropdowmClass = 'dropdowm_wrapp_2';
    $dropdowmClass2 = 'dropdowm_wrapp_2 dropdowm_wrapp_2_2';
    $contentClass = 'content_resp';
    $searchIconClass = 'search_icon_black';
    $blackClass = '_black';
}

\conquer\modal\ModalForm::widget([
    'selector' => '.modal-form',
    'clientOptions' => [
        //'id' => 'sample-unique-id',
        //'class' => 'sample-class1 sample-class2',
        //'tabindex' => false
    ]
]);
$wishAmount = \Yii::$app->wishlist->getUserWishlistAmount();
$countCircle = !empty($wishAmount) ? '<span class="count_circle">' . $wishAmount . '</span>' : '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body <?= $bodyClass ?> >
<?php $this->beginBody(); ?>
<div class="wrapper">
    <header>
        <div class="<?= $headerClass ?>">
            <div class="row clearfix">
                <div class="left">
                    <button class="respmenubtn respmenubtn_2 menu_btn_2">
						<span class="sp_1">
							<span></span>
							<span></span>
							<span></span>
						</span>
						<span class="sp_2">
							<span><?= Yii::t('app', 'Menu') ?></span>
						</span>
                    </button>
                </div>
                <div class="center">
                    <div class="logo_city">
                        <div class="logo_wrapp <?= $logoClass ?>">
                            <?= $logoImg ?>
                        </div>
                        <?= common\widgets\CountOfficeWidget::widget() ?>
                    </div>
                </div>
                <div class="right">
                    <div class="search_sect inline append-elem" data-append-desktop-elem="2" data-min-screen="900">
                        <a href="#" class="search_open">
                            <i class="<?= $searchIconClass ?>"></i>
                        </a>
                    </div>
                    <div class="top_menu novisible_1380 add-advert-head">
                                <a href="/" class="p_width">Добавить объявление</a>
                    </div>
                    <div class="inline append-elem" data-append-desktop-elem="3" data-min-screen="900">
                        <div class="favorite_box">
                            <a href="/favorite" class="icon_link">
                                <i class="star_icon<?= $blackClass ?>"></i>
                                <div id="count-wishlist-badge"><?= $countCircle ?></div>
                            </a>
                        </div>
                    </div>
                    <div class="inline user-block append-elem" data-append-desktop-elem="4" data-min-screen="900">
                            <div class="user_wrapp">
                                <a href="login" class="icon_link">
                                    <i class="user_icon<?= $blackClass ?>"></i>
                                </a>
                            </div>
                    </div>
                    <div class="top_menu append-elem" data-append-desktop-elem="5" data-min-screen="470">
                        <?php echo common\widgets\LangWidget::widget() ?>
                        <?php
                        if ($changeCurrency) echo common\widgets\CurrencyWidget::widget();
                        ?>
                    </div>
                </div>
            </div>
            <?= $this->render('_partial/_search', [
                'result' => Yii::$app->controller->result
            ]); ?>
            <div class="main_nav_wrapp <?= $mainNavClass ?>" id="resp_nav">
                <div class="inline_blocks">
                    <div class="append-elem" data-append-elem="2"></div>
                    <div class="append-elem" data-append-elem="3"></div>
                    <div class="append-elem" data-append-elem="4"></div>
                    <div class="append-elem" data-append-elem="5"></div>
                </div>
                <div class="menu_2">
                    <?php echo common\widgets\TopMenuWidget::widget() ?>
                    <div class="add-advert">
                        <a href="/" class="p_width">Добавить объявление</a>
                    </div>
                </div>
            </div>
            <?= Alert::widget() ?>
        </div>
    </header>


    <div class="content <?= $contentClass ?>">
        <?= $content ?>
    </div>

    <!-- Footer -->

    <footer class="footer_section">
        <div class="footer_content">
            <div class="row">
                <div class="footer_templ clearfix">
                    <?= common\widgets\FootMenuWidget::widget(); ?>
                </div>
            </div>
        </div>
        <div class="corp_wrapp">
            <div class="row">
                <p><span>&copy;</span> Allbc.info, 2015-<?= date('Y') ?>. Все права защищены</p>
            </div>
        </div>

    </footer>

    <!-- /Footer -->
    <div class="popup_bg"></div>

    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
