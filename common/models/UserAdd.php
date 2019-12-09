<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $verification_token
 * @property int $is_activated
 * @property string $activated_at
 * @property string $last_login
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property int $sex
 * @property string $broker_phone
 */
class UserAdd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'is_activated', 'sex'], 'integer'],
            [['activated_at', 'last_login'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'name', 'surname'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone', 'broker_phone'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'is_activated' => Yii::t('app', 'Is Activated'),
            'activated_at' => Yii::t('app', 'Activated At'),
            'last_login' => Yii::t('app', 'Last Login'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'phone' => Yii::t('app', 'Phone'),
            'sex' => Yii::t('app', 'Sex'),
            'broker_phone' => Yii::t('app', 'Broker Phone'),
        ];
    }
}
