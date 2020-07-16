<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\BcValutes;

class RatesController extends Controller
{
    public function actionRates($pass)
    {
        if ($pass == '2jpxcalld3fnmlsmt8hkwf4oty2u35bccfqadc1r') {

            $url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
            $content = file_get_contents($url);
            $result = json_decode($content, TRUE);

            $rates = array_filter($result, function ($r) {
                return $r['r030'] == 840 || $r['r030'] == 978 || $r['r030'] == 643;
            });

            $html = '<div><p><b>Курсы валют на ' . $result[0]['exchangedate'] . '</b></p>';

            foreach ($rates as $rate) {
                $html .= '<p>' . $rate['txt'] . ' - ' . $rate['rate'] . '</p>';
                switch ($rate['r030']) {
                    case 643:
                        $model = BcValutes::find()->where(['id' => 4])->one();
                        break;
                    case 840:
                        $model = BcValutes::find()->where(['id' => 2])->one();
                        break;
                    case 978:
                        $model = BcValutes::find()->where(['id' => 3])->one();
                        break;
                    default:
                        break;
                }
                $model->rate = $rate['rate'];
                $model->save();
            }
            $html .= '</div>';
        } else {
            $html = '<p>У вас нет доступа к этой странице</p>';
        }

        return $html;
    }

}

