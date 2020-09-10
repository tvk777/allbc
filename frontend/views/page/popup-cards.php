<?
use yii\helpers\Html;

$currentLanguage = Yii::$app->language;

echo Html::beginForm(['page/popup-cards'], 'post', ['data-pjax' => true, 'id' => 'popupForm']);
echo Html::input('hidden', 'markerId', '', ['id' => 'markerId']);
echo Html::input('hidden', 'result', $params['result'], ['id' => 'popupResult']);
echo Html::input('hidden', 'target', $params['target'], ['id' => 'popupTarget']);
echo Html::input('hidden', 'currency', $params['currency'], ['id' => 'popupCurrency']);
echo Html::endForm();
//debug($searchResult);
if (!empty($params['markerId']) && !empty($searchResult) && count($searchResult['items']) > 0) {
    $street = $searchResult['streetName'];
    $places = $searchResult['items'];
    //$mainBc = $places[0]->bcitem;
    //$mainPlace = $places[0]->place;
    $address = $street; //$mainBc->address; //BcItem - isset address, BcPlaces - not isset address
    if ($params['result'] === 'bc') {
        $mainItem = $places[0]->bcitem;
        $address = $mainItem->address;
    } else {
        $mainItem = $places[0]->place;
        $address = $street;
    }
    $link = !empty($mainItem) && !empty($mainItem->slug) ? $mainItem->slug->slug : '#';
}
?>
<div class="popup popup_sect map_objects_popup" data-popup="popup_2">
    <? if (!empty($params['markerId']) && !empty($searchResult) && count($searchResult['items']) > 0) : ?>
        <div class="popup_content">
            <div class="map_objects_templ">
                <div class="objects_adress">
                    <div>
                        <button type="button" class="close_btn_2 close_popup"></button>
                    </div>
                    <? $bgStyle = count($mainItem->slides) > 0 ? 'style="background-image: url(' . $mainItem->slides[0]['big'] . ')"' : ''; ?>
                    <div class="inner_bg" <?= $bgStyle ?>>
                        <div>
                            <p><?= $address ?></p>
                        </div>
                        <div>
                            <a target="_blank" href="/<?= $link ?>" class="orange_pill"><?= Yii::t('app', 'More') ?></a>
                        </div>
                    </div>
                </div>

                <!--<div class="params">
                    <p>id=<?/*= $params['markerId'] */?></p>
                    <p>result=<?/*= $params['result'] */?></p>
                    <p>target=<?/*= $params['target'] */?></p>
                    <p>curr=<?/*= $params['currency'] */?></p>
                </div>-->

                <div class="map_objects_thumbs">
                    <? foreach ($places as $place) : ?>
                        <?= $this->render('_partial/_card', [
                            'item' => $place,
                            'target' => $params['target'],
                            'result' => 'offices',
                            'currentLanguage' => $currentLanguage,
                            'currency' => $params['currency'],
                            'rates' => $rates,
                            'taxes' => $taxes
                        ]); ?>
                    <? endforeach; ?>
                </div>

            </div>
        </div>
    <? endif; ?>
</div>


