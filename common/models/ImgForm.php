<?php
namespace common\models;
use Yii;
use yii\base\Model;

class ImgForm extends Model
{
    public $title;
    public $description;
    public $disk_name;


    public function rules()
    {
        return [
            [['disk_name'], 'required'],
            [['title', 'description', 'disk_name'], 'string'],
        ];
    }

}