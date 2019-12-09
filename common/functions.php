<?php

function debug($arr){
    echo '<pre>'.print_r($arr, true).'</pre>';
}

//return true if all values of array is empty
function isEmptyValues ($arr){
    $flag = true;
    foreach($arr as $val){
       if(strlen(trim($val))>0){
           $flag=false;
           break;
       }
    }
    return $flag;
}

//get content for default language if no translate
function getDefaultTranslate($attribute, $suffix, $translates, $notMulti = false){
    $att = $attribute.'_'.$suffix;
    if($notMulti && $suffix=='ru') return $translates->$attribute;
    if ($translates->$att && $translates->$att != '') {
        $content = $translates->$att;
    } else {
        $content = $translates->$attribute;
    }
    return $content;
}

function getLangInflect($model, $suffix){
    switch ($suffix){
        case 'ru':
            return $model->inflect;
        break;
        case 'ua':
            return $model->inflect_ua;
            break;
        case 'en':
            return $model->name;
            break;
    }
}

/**
 * Checks if a folder exist and return canonicalized absolute pathname (sort version)
 * @param string $folder the path being checked.
 * @return mixed returns the canonicalized absolute pathname on success otherwise FALSE is returned
 */
function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    //return ($path !== false AND is_dir($path)) ? $path : false;
    return is_dir($path) ? $path : false;
}

function FilterAndTrim($arr){
    return array_filter($arr, function($item) {
        return !empty(trim($item));
    });
}