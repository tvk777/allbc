<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$user = Yii::$app->user->identity;
//debug($user->avatar);
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= $user->name . ' ' . $user->surname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header ">
                            <div class="author_photo">
                                <img src="<?= $user->avatar ?>" class="img-circle" />
                            </div>
                            <p><?= $user->name . ' ' . $user->surname ?></p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <?= Html::a(
                                'Sign out',
                                ['/site/logout'],
                                ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                            ) ?>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
