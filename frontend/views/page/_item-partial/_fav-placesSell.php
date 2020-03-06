<?php
use kriptograf\wishlist\widgets\WishlistButton;

?>
<div class="scroll_x">
    <table class="table_5 places_table">
        <thead>
        <tr class="table_row head">
            <th class="table_cell">
                <h4>м²</h4>
            </th>
            <th class="table_cell">
                <div class="custom_select_wrapp custom_select_wrapp_3">
                    <span>₴/m²</span>
                </div>
            </th>
            <th class="table_cell">
                <div class="custom_select_wrapp custom_select_wrapp_3">
                    <span>All in</span>
                </div>
            </th>
            <th class="table_cell">
            </th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($places as $index => $place) : ?>
            <?
            $plus = '';
            $placePrices = $place->prices;
            $prices = count($placePrices) > 0 ? $place->getPricePeriod($placePrices) : Yii::t('app', 'con.');
            if (count($placePrices) > 0) {
                $uah = $prices['uah']['m2'];
                $uah_full = $prices['uah']['full'];
                if ($prices['uah']['value'] < $uah_full) $plus = '+';
            } else {
                $uah = $uah_full = Yii::t('app', 'con.');
            }
            ?>

            <tr class="table_row" id="place<?= $place->id ?>">
                <td class="table_cell">
                    <p><?= $place->m2range ?></p>
                </td>
                <td class="table_cell m2">
                    <p><?= $uah . $plus ?></p>
                </td>
                <td class="table_cell period">
                    <p><?= $uah_full ?></p>
                </td>
                <td class="table_cell">
                    <a href="#" class="photo_link"></a>
                    <div class="star_checkbox">
                        <?= WishlistButton::widget([
                            'model' => $place,
                            'anchorActive' => '<i class="fav rem"></i>',
                            'anchorUnactive' => '<i class="fav"></i>',
                            'cssClass' => 'out-wish',
                            'cssClassInList' => 'in-wish'
                        ]); ?>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</div>
