<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use common\models\Config;

class Settings extends Component {

    private $_attributes;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $config = Config::find()->all();
        $this->_attributes = ArrayHelper::map($config, 'name', 'val');
    }

    public function __get($name) {
        if (array_key_exists($name, $this->_attributes))
            return $this->_attributes[$name];

        return parent::__get($name);
    }
}