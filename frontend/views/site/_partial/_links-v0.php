<?php
//debug($rentLinks);
?>

<div class="row">
    <h2>Популярные запросы</h2>
    <div class="pills_list_wrapp">
        <ul>
            <li class="switch-type"><a id="rent" href="<?= $mainRent ?>" class="active">Аренда</a></li>
            <li class="switch-type"><a id="sale" href="<?= $mainSell ?>">Продажа</a></li>
        </ul>
    </div>

    <div class="selects_sect offset_ziro">
        <div class="rent-links">
            <? foreach ($rentLinks as $category) : ?>
                <div class="col">
                    <div class="select_4_wrapp">
                        <div class="custom_select_2">
                            <div class="custom_select_title"><a href="#"><?= $category->category_name ?></a></div>
                            <div class="custom_select_list">
                                <? foreach ($category->links2 as $l) : ?>
                                    <div class="custom_select_item"><a href="<?= $l->link_href ?>"><?= $l->link_name ?></a></div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
        <div class="sale-links">
            <? foreach ($saleLinks as $category) : ?>
                <div class="col">
                    <div class="select_4_wrapp">
                        <div class="custom_select_2">
                            <div class="custom_select_title"><a href="#"><?= $category->category_name ?></a></div>
                            <div class="custom_select_list">
                                <? foreach ($category->links3 as $l) : ?>
                                    <div class="custom_select_item"><a href="<?= $l->link_href ?>"><?= $l->link_name ?></a></div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>

</div>