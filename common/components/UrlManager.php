<?php
/*
 * не учтены параметры, надо доделывать
 */

namespace common\components;

use Yii;
use common\models\Slugs;

class UrlManager extends \yii\web\UrlManager {

    public function createUrl($params){
        $route = trim($params[0], '/');
        $controller = explode('/',$route)[0];
        if ($controller !== 'page' || isset($params['slug']) === false) {
            return parent::createUrl($params);
        }
        $action = Slugs::find()->select('model')->where(['slug' => $params['slug']])->scalar();
        if ($action !== false) {
            $link = '';
            foreach ($params as $key => $value) {
                if ($key !=='slug' && $key !=='filter' && $key !== 0) {
                    $link .= $key.'='.$value.'&';
                } else if($key ==='filter'){
                    foreach($params['filter'] as $k => $v){
                        //debug($v); die();
                        if(!is_array ($v)){
                            $link .='filter['.$k.']='.$v.'&';
                        } else{
                            foreach($v as $one){
                                $link .='filter['.$k.'][]='.$one.'&';   
                            }
                        }
                        //$link .='filter['.$k.']='.$v.'&';
                    }
                }
            }
            if($link !== ''){
                $link = substr($link, 0, -1); //удаляем последний символ (&)
                return '/' . $params['slug'].'?'.$link;
            }

            return '/' . $params['slug'];
        }
        return parent::createUrl($params);
    }
    public function parseRequest($request)
    {
        $url = trim($this->_request->getPathInfo(), '/');
        $page = Slugs::find()->where(['slug' => $url])->one();
        //debug($page);die();
//controller = page, action = 'model' from table slugs
        if ($page !== null) {
            $url = ['page/'.$page->model, ['slug' => $page->slug]];
            //debug($url);
            return ['page/'.$page->model, ['slug' => $page->slug]];
        }
        return parent::parseRequest($request);
    }
}