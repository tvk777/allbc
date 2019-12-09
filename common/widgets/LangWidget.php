<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;



class LangWidget extends Widget{
    public $array_languages;
    private static $_labels;
    private $_isError;

    public function init()
    {
        foreach (Yii::$app->urlManager->languages as $language) {
            $this->array_languages[self::label($language)] = $language;
        }
        parent::init();
    }

    public function run() {
        $currentLanguage = Yii::$app->language;
        $currentLable = self::label($currentLanguage);
        return $this->render('lang',[
            'array_lang' => $this->array_languages,
            'currentLanguage' => $currentLanguage,
            'currentLable' => $currentLable,
        ]);
    }

    public static function label($code)
    {
        if (self::$_labels === null) {
            self::$_labels = [
                'ru' => 'ru',
                'ua' => 'ua',
                'en' => 'eng',
            ];
        }

        return isset(self::$_labels[$code]) ? self::$_labels[$code] : null;
    }

}