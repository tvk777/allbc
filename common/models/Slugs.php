<?php

namespace common\models;

use Yii;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;

/**
 * This is the model class for table "slugs".
 *
 * @property int $id
 * @property string $model
 * @property int $model_id
 * @property string $slug
 */
class Slugs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slugs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id'], 'integer'],
            //[['slug'], 'required'],
            [['slug'], 'safe'],
            [['model', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }

    public static function generateSlug($model, $model_id, $slug)
    {
        $slug = Inflector::slug(TransliteratorHelper::process($slug), '-', true);
        if (self::checkUniqueSlug($model, $model_id, $slug)) {
            return $slug;
        } else {
            for ($suffix = 1, $new_slug = $slug; !self::checkUniqueSlug($model, $model_id, $new_slug); $suffix++, $new_slug = $slug . '-' . $suffix) {
            }
            return $new_slug;
        }
    }

    private function checkUniqueSlug($model, $model_id, $slug)
    {
        if(!$model_id){
            $condition = ['slug' => $slug];
        } else{
            $condition = ['slug' => $slug, 'model_id' => !$model_id, 'model' => !$model];
        }
        return !Slugs::find()->where($condition)->one();
    }

    public static function initialize($model, $model_id, $alias)
    {
        $slug = new Slugs();
        $slug->model_id = $model_id;
        $slug->model = $model;
        $slug->slug = $alias;
        $slug->save();
        return $slug->id;
    }

    public static function updateSlug($model, $model_id, $alias)
    {
        $slug = Slugs::find()->where(['model_id' => $model_id, 'model' => $model])->one();
        $slug->slug = $alias;
        $slug->save();
        return $slug->id;
    }



}
