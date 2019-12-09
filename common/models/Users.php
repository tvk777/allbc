<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $activation_code
 * @property string $persist_code
 * @property string $reset_password_code
 * @property string $permissions
 * @property int $is_activated
 * @property string $activated_at
 * @property string $last_login
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $surname
 * @property string $deleted_at
 * @property string $last_seen
 * @property int $is_guest
 * @property int $is_superuser
 * @property string $phone
 * @property string $href
 * @property string $password_old
 * @property int $sex
 * @property string $broker_phone
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['permissions'], 'string'],
            [['is_activated', 'is_guest', 'is_superuser', 'sex'], 'integer'],
            [['activated_at', 'last_login', 'created_at', 'updated_at', 'deleted_at', 'last_seen'], 'safe'],
            [['name', 'email', 'password', 'activation_code', 'persist_code', 'reset_password_code', 'username', 'surname'], 'string', 'max' => 255],
            [['phone', 'broker_phone'], 'string', 'max' => 100],
            [['href'], 'string', 'max' => 150],
            [['password_old'], 'string', 'max' => 50],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'activation_code' => Yii::t('app', 'Activation Code'),
            'persist_code' => Yii::t('app', 'Persist Code'),
            'reset_password_code' => Yii::t('app', 'Reset Password Code'),
            'permissions' => Yii::t('app', 'Permissions'),
            'is_activated' => Yii::t('app', 'Is Activated'),
            'activated_at' => Yii::t('app', 'Activated At'),
            'last_login' => Yii::t('app', 'Last Login'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'username' => Yii::t('app', 'Username'),
            'surname' => Yii::t('app', 'Surname'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'last_seen' => Yii::t('app', 'Last Seen'),
            'is_guest' => Yii::t('app', 'Is Guest'),
            'is_superuser' => Yii::t('app', 'Is Superuser'),
            'phone' => Yii::t('app', 'Phone'),
            'href' => Yii::t('app', 'Href'),
            'password_old' => Yii::t('app', 'Password Old'),
            'sex' => Yii::t('app', 'Sex'),
            'broker_phone' => Yii::t('app', 'Broker Phone'),
        ];
    }
}
