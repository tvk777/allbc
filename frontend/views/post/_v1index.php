<?php
use yii\helpers\Html;

//debug($posts);
?>

<div class="post-index">

    <h1><?= Yii::t('app', 'Список постов') ?></h1>
    <?php
    foreach ($posts as $post) {
        echo '<div class="post">';
        $default_content = '';
        $current_content = '';
        echo $post->id . '</br>';
        foreach ($post->langPosts as $content) {
            if ($default_language == $current_language) {
                if ($content->lang == $default_language) {
                    $default_content = $content;
                    $current_content = $content;
                }
            } else {
                if ($content->lang == $default_language) {
                    $default_content = $content;
                } elseif ($content->lang == $current_language) {
                    $current_content = $content;
                }
            }
        }

        if ($current_content->title && $current_content->title != '') {
            echo '<h4>' . $current_content->title . '</h4>';
        } else {
            echo '<h4>' . $default_content->title . '</h4>';
        }
        if ($current_content->text && $current_content->text != '') {
            echo '<h4>' . $current_content->text . '</h4>';
        } else {
            echo '<h4>' . $default_content->text . '</h4>';
        }

        echo '</div>';
    }
    ?>


</div>