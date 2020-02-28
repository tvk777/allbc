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

AppAsset::register($this);
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

if ($controller == 'site' && $action != 'index') {
    $bodyClass = 'class="' . $controller . ' ' . $action . ' pages"';
} else {
    $bodyClass = 'class="' . $controller . ' ' . $action . '"';
}
$headerClass = '';
$logoClass = '';
$logoImg = Html::img('@web/img/logo.svg', ['alt' => 'Логотип']);
$searchIconClass = 'search_icon';
$dropdowmClass = '';
$dropdowmClass2 = '';
$contentClass = '';
$blackClass = '';

if ($action != 'index') {
    $headerClass = 'header_site_inner header_1';
    $logoClass = 'logo_wrapp_2';
    $logoImg = Html::a(Html::img('@web/img/logo_2.svg', ['alt' => 'Логотип', 'class' => 'logo_black']), [Url::home()]);
    $dropdowmClass = 'dropdowm_wrapp_2';
    $dropdowmClass2 = 'dropdowm_wrapp_2 dropdowm_wrapp_2_2';
    $contentClass = 'content_2 content_resp';
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
$countCircle = !empty($wishAmount) ? '<span class="count_circle">'.$wishAmount.'</span>' : '';
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
        <div class="header_site <?= $headerClass ?>">
            <div class="row clearfix">
                <div class="left">
                    <div class="logo_wrapp <?= $logoClass ?>">
                        <?= $logoImg ?>
                    </div>
                    <?= common\widgets\CountOfficeWidget::widget() ?>
                </div>
                <div class="right">
                    <div class="search_sect inline append-elem" data-append-desktop-elem="2" data-min-screen="600">
                        <a href="#" class="search_open">
                            <i class="<?= $searchIconClass ?>"></i>
                        </a>
                    </div>
                    <div class="top_menu append-elem" data-append-desktop-elem="1" data-min-screen="800">
                        <div class="dropdowm_wrapp <?= $dropdowmClass2 ?>">
                            <div class="dropdown_title">
                                <p class="p_width">Добавить объявление</p>
                                <input type="text" name="" placeholder="Добавить объявление" readonly/>
                            </div>
                            <div class="dropdown_menu">
                                <ul>
                                    <li><a href="#" title="" class="active"/>Объявление 1</a></li>
                                    <li><a href="#" title=""/>Объявление 2</a></li>
                                    <li><a href="#" title=""/>Объявление 3</a></li>
                                    <li><a href="#" title=""/>Объявление 4</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="inline append-elem" data-append-desktop-elem="3" data-min-screen="600">
                        <div class="favorite_box">
                            <a href="/favorite" class="icon_link">
                                <i class="star_icon<?= $blackClass ?>"></i>
                                <div id="count-wishlist-badge"><?= $countCircle ?></div>
                            </a>
                        </div>
                    </div>
                    <div class="top_menu append-elem" data-append-desktop-elem="4" data-min-screen="600">
                        <div class="dropdowm_wrapp">
                            <div class="dropdown_title user_wrapp">
                                <a href="login" class="icon_link">
                                    <i class="user_icon<?= $blackClass ?>"></i>
                                </a>
                            </div>
                            <div class="dropdown_menu">
                                <ul>
                                    <? if (Yii::$app->user->isGuest) : ?>
                                    <li>
                                        <?= Html::a(
                                            Yii::t('app', 'Login'),
                                            ['/login'],
                                            ['class' => 'link_2 modal-form size-middle']
                                        ) ?>
                                    </li>
                                    <? else : ?>
                                    <li>
                                        <?= Html::a(
                                            Yii::t('app', 'Logout'),
                                            ['/logout'],
                                            ['data-method' => 'post']
                                        ) ?>
                                    </li>
                                    <? endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="top_menu append-elem" data-append-desktop-elem="5" data-min-screen="450">
                        <?php echo common\widgets\LangWidget::widget() ?>
                    </div>
                    <button class="respmenubtn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
            <div class="search_popup">
                <form class="search_form" method="post">
                    <input type="text" placeholder="Что ищем" class="search_input"/>
                    <input type="submit" class="search_submit" value=" "/>
                    <button type="button" class="close_x"></button>
                </form>
                <div class="search_result">
                    <a href="#" class="res_item">
                        <h4>Поисковый результат</h4>
                        <p>Текст найденного контента. Текст найденного контента. Текст найденного контента.</p>
                    </a>
                    <a href="#" class="res_item">
                        <h4>Поисковый результат</h4>
                        <p>Текст найденного контента. Текст найденного контента. Текст найденного контента.</p>
                    </a>
                    <a href="#" class="res_item">
                        <h4>Поисковый результат</h4>
                        <p>Текст найденного контента. Текст найденного контента. Текст найденного контента.</p>
                    </a>
                </div>
            </div>
            <div class="main_nav_wrapp" id="resp_nav">
                <div class="inline_blocks">
                    <div class="append-elem" data-append-elem="2"></div>
                    <div class="append-elem" data-append-elem="3"></div>
                    <div class="append-elem" data-append-elem="4"></div>
                    <div class="append-elem" data-append-elem="5"></div>
                </div>
                <div class="main_nav">
                    <div class="append-elem" data-append-elem="1"></div>
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


    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
