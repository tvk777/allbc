<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\SystemFiles;



class UploadImagesWidget extends Widget
{
    public $model;
    public $form;
    public $uploadAction = 'upload-image';
    public $deleteAction = 'delete-image';
    public $sortAction = 'sort-image';
    public $multi = true;
    public $allwoedFiles = NULL;
    public $maxFileCount = 10;
    public $field = 'imgs';


    public function run()
    {
        if($this->multi === true) {
            $initialPreview = $this->ImagesPreview();
            $initialPreviewConfig = $this->ImagesLinksData();
        } else {
            $initialPreview = $this->ImagePreview();
            $initialPreviewConfig = $this->ImageLinkData();
        }

        $uploadUrl[] = $this->uploadAction;

        if($this->multi === true){
            $view = 'input-multi-files';
        } else{
            $view = 'input-single-file';
        }
        if($this->field!=='imgs') {
            $uploadUrl['field'] = $this->field;
        }
        if($this->allwoedFiles!==null) {
            $allwoedFiles = implode($this->allwoedFiles, '-');
            $uploadUrl['allwoedFiles'] = $allwoedFiles;
        }

        $deleteAction = Url::to([$this->deleteAction]);
        $sortAction = Url::toRoute([$this->sortAction,"id"=>$this->model->id]);
        $uploadAction = Url::to($uploadUrl);
        return $this->render($view, [
            'initialPreview' => $initialPreview, 
            'initialPreviewConfig' => $initialPreviewConfig, 
            'maxFileCount' => $this->maxFileCount, 
            'multi' => $this->multi,  
            'model' => $this->model,  
            'form' => $this->form, 
            'uploadAction' => $uploadAction,
            'deleteAction' => $deleteAction,
            'sortAction' => $sortAction,
        ]);
    }

    //multi mode
    private function ImagesPreview()
    {
        $Preview = [];
        if(!empty($this->model->images)) {
            foreach ($this->model->images as $img) {
                $Preview[] = Html::a(Html::img($img->imgSrc), ['/system-files/update', 'id' => $img->id], ['class' => 'modal-form size-middle']);
            }
        }
        return $Preview;
    }

    private function ImagesLinksData()
    {
        $images = $this->model->images;
        if(empty($images)){return []; }
        return ArrayHelper::toArray($images, [
                SystemFiles::className() => [
                    'caption' => function ($images) {
                        $title = $images->title ? $images->title : $images->file_name;
                        //$descr = $images->description ? $images->description : '';
                        //return $title.'<br>'.$descr;
                        return $title;
                    },
                    'key' => 'id',
                ]]
        );
    }

    //single mode
    private function ImagePreview()
    {
        $Preview = [];
        $img = $this->model->image;
        if($img) {
            $Preview[] = Html::a(Html::img($img->imgSrc), ['/system-files/update', 'id' => $img->id], ['class' => 'modal-form size-middle']);
        }
        return $Preview;
    }

    private function ImageLinkData()
    {
        $image = $this->model->image;
        if(empty($image)){return []; }
        return [[
            'caption' => $image->title ? $image->title : $image->file_name,
            'key' => $image->id,
            ]];
    }



}