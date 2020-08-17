<? if (!empty($subways)) : ?>
    <div class="sub-result col-xs-12">
        <div class="col-xs-1 text-right"><i class="green_metro"></i></div>
        <div class="col-xs-11">
            <? foreach ($subways as $subway) : ?>
                <? $slug = $target == 'rent' ? $subway->city->slug : $subway->city->slug_sell; ?>
                <a class="res_item" href="/<?= $slug ?>?filter[subway]=<?= $subway->id ?>">
                    <p><?= $subway->name ?></p>
                </a>
            <? endforeach; ?>
        </div>
    </div>
<? endif; ?>

<? if (!empty($districts)) : ?>
    <div class="sub-result col-xs-12">
        <div class="col-xs-1 text-right"><i class="green_marker"></i></div>
        <div class="col-xs-11">
            <? foreach ($districts as $district) : ?>
                <? $slug = $target == 'rent' ? $district->city->slug : $district->city->slug_sell; ?>
                <a class="res_item" href="/<?= $slug ?>?filter[districts][]=<?= $district->id ?>">
                    <p><?= $district->name ?></p>
                </a>
            <? endforeach; ?>
        </div>
    </div>
<? endif; ?>

<? if (!empty($bcitems)) : ?>
    <div class="sub-result col-xs-12">
        <div class="col-xs-1 text-right"><i class="green_apartment"></i></div>
        <div class="col-xs-11">
            <? foreach ($bcitems as $bcitem) : ?>
                <a class="res_item" href="/<?= $bcitem->slug->slug ?>?target=<?= $target ?>">
                    <p><?= $bcitem->name ?></p>
                </a>
            <? endforeach; ?>
        </div>
    </div>
<? endif; ?>

<? if (!empty($places)) : ?>
    <div class="sub-result col-xs-12">
        <div class="col-xs-1 text-right"><i class="green_apartment"></i></div>
        <div class="col-xs-11">
            <? foreach ($places as $place) : ?>
                <a class="res_item" href="/<?= $place->slug->slug ?>?target=<?= $target ?>">
                    <p><?= $place->name ?></p>
                </a>
            <? endforeach; ?>

        </div>
    </div>
<? endif; ?>


