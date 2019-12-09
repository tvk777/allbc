<?php
foreach($attributes as $attr => $editor){
    if($lang!=Yii::$app->params['default_lang']) {
        $a = $attr . '_' . $lang;
    } else{
        $a = $attr;
    }
    if($editor===1){
        echo $form->field($model, $a)->widget(mihaildev\ckeditor\CKEditor::className(), [
         'editorOptions' => [mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder'),
            'preset' => 'standard',
         ]
       ]);
    } else{
        echo $form->field($model, $a)->textInput();
    }
}
