<?php
namespace common\models;
use Yii;
class Subscription extends \yii\db\ActiveRecord{
    public static function tableName()
    {
        return '{{%subscription}}';
    }
    public function rules(){
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'trim'],
            [['email'], 'unique'],
            [['email', 'addtime'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'email' => 'Email',
            'addtime' => 'Время добавления',
        ];
    }
}