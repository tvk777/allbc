<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "views_counter".
 *
 * @property int $id
 * @property int $item_id
 * @property int $count_view
 * @property string $model
 */
class ViewsCounter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'views_counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'model'], 'required'],
            [['item_id', 'count_view'], 'integer'],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'count_view' => Yii::t('app', 'Count View'),
            'model' => Yii::t('app', 'Model'),
        ];
    }

    public function processCountViewItem()
    {
        $session = Yii::$app->session;
        //unset($session['bcitem_view']);
        // Если в сессии отсутствуют данные,
        // создаём, увеличиваем счетчик, и записываем в бд
        if (!isset($session['bcitem_view'])) {
            $session->set('bcitem_view', [$this->item_id]);
            $this->updateCounters(['count_view' => 1]);
            // Если в сессии уже есть данные то проверяем засчитывался ли данный пост
            // если нет то увеличиваем счетчик, записываем в бд и сохраняем в сессию просмотр этого поста
        } else {
            if (!ArrayHelper::isIn($this->item_id, $session['bcitem_view'])) {
                $array = $session['bcitem_view'];
                array_push($array, $this->item_id);
                $session->remove('bcitem_view');
                $session->set('bcitem_view', $array);
                $this->updateCounters(['count_view' => 1]);

            }
        }

        return true;
    }

}
