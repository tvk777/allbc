<?php
//debug($images[0]['title']);
?>
<section class="info_side_promo" style="background-image: url(<?= $images[0]['url'] ?>);">
    <div class="promo_slider">
        <? foreach ($images as $img) : ?>
        <div>
            <div class="slide" style="background-image: url(<?= $img['url'] ?>);"></div>
        </div>
        <? endforeach; ?>
    </div>
    <div class="row">
        <div class="promo_text">
            <h1><?= $text[0] ?></h1>
            <h2><?= $text[1] ?></h2>
        </div>
        <div class="promo_footer">
            <p>Фото: <a href="#">regus silver breeze</a></p>
        </div>
    </div>
    <div class="promo_slider_arrows"></div>
</section>






			
