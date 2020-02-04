<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * OrderForm is the model behind the order form.
 */
class OrderForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $body;
    public $subject;
    public $toEmail;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'body', 'toEmail', 'subject'], 'required'],
            // email has to be a valid email address
            [['email', 'toEmail'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'body' => 'Message',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendOrder()
    {
        return Yii::$app->mailer->compose()
            ->setTo($this->toEmail)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
