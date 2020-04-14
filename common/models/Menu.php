<?php

namespace common\models;

use Yii;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $url
 * @property int $coll
 * @property int $sort_order
 */
class Menu extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'ua' => 'Ukrainian',
                    'en' => 'English',
                ],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'menu_id',
                'tableName' => "{{%menuLang}}",
                'attributes' => [
                    'text'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'coll', 'menu'], 'required'],
            [['coll', 'sort_order'], 'integer'],
            [['url'], 'string', 'max' => 127],
            [['menu'], 'string', 'max' => 16],
            [['text', 'text_ru', 'text_ua', 'text_en',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'coll' => Yii::t('app', 'Coll'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'menu' => Yii::t('app', 'Menu'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public static function findTopMenu()
    {
        return self::find()->where(['menu' => 'main'])->multilingual()->orderBy('sort_order')->all();
    }

    public static function findByColl()
    {
        $items = self::find()->where(['menu' => 'foot'])->multilingual()->orderBy('sort_order')->all();
        $menu = [];
        foreach($items as $item){
            switch ($item->coll){
                case 1:
                    $menu[1][]=$item;
                    break;
                case 2:
                    $menu[2][]=$item;
                    break;
                case 3:
                    $menu[3][]=$item;
                    break;
                default:
                    return false;
            }
        }

        return $menu;
    }

}
