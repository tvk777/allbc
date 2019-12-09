<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\SystemFiles;
use common\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use Imagine\Image\Point;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'partners', 'upload-image', 'delete-image', 'sort-image', 'slider', 'upload-slide', 'delete-slide', 'sort-slide'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete-image' => ['POST'],
                    'upload-image' => ['POST'],
                    'sort-image' => ['POST'],
                    'delete-slide' => ['POST'],
                    'upload-slide' => ['POST'],
                    'sort-slide' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPartners()
    {
        $images = SystemFiles::find()->where(['attachment_type' => 'partners'])->orderBy('sort_order')->all();
        $imagesLinks = SystemFiles::getImagesLinks($images);
        $imagesLinksData = SystemFiles::getImagesLinksData($images);
        if (Yii::$app->request->post()) {
            //debug($_FILES); die();
        }
        return $this->render('partners', [
            'images' => $images,
            'imagesLinks' => $imagesLinks,
            'imagesLinksData' => $imagesLinksData,
        ]);
    }


    public function actionUploadImage()
    {
        $files = UploadedFile::getInstancesByName('Images');
        if (!empty($files) && count($files>0)) {
            $file = $files[0];
            $file_size = $file->size;
            $content_type = $file->type;
            $file_name = $file->name;
            $disk_name = SystemFiles::getDiskName($file);
            $path = Yii::getAlias('@uploads') . '/' . SystemFiles::getPartitionDirectory($disk_name);
            FileHelper::createDirectory($path);
            $file->saveAs($path . DIRECTORY_SEPARATOR . $disk_name);

            $image = new SystemFiles();
            $image->attachment_type = 'partners';
            $image->file_name = $file_name;
            $image->disk_name = $disk_name;
            $image->file_size = $file_size;
            $image->content_type = $content_type;
            $image->sort_order = SystemFiles::find()->where(['attachment_type' => 'partners'])->count();
            if (!$image->save()) {
                throw new NotFoundHttpException('The requested image does not save.');
            } else {
                $originalImage = $path . DIRECTORY_SEPARATOR . $disk_name;
                $size = getimagesize($originalImage);
                $originalWidth = $size[0];
                $originalHeight = $size[1];
                $maxWidth = 160;
                $maxHeight = 60;
                $thumb_name = 'thumb_' . $image->id . '.' . $file->extension;
                $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET;
                if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                    Image::thumbnail($originalImage, $maxWidth, $maxHeight, $mode)
                        ->save($path . DIRECTORY_SEPARATOR . $thumb_name, ['quality' => 80, 'thumbnailBackgroundColor' => 'fff']);
                } else{
                    Image::getImagine()->open($originalImage)
                        ->thumbnail(new Box($originalWidth, $originalHeight))
                        ->save($path . DIRECTORY_SEPARATOR . $thumb_name, ['quality' => 80, 'thumbnailBackgroundColor' => 'fff']);
                }
                return true;
            }
        }
    }

    public function actionDeleteImage()
    {
        if(($model = SystemFiles::findOne(Yii::$app->request->post('key'))) && $model->delete()){
            SystemFiles::updateAllCounters(['sort_order' => -1], [
                'and', ['attachment_type' => 'partners'], ['>','sort_order', $model->sort_order ]
            ]);
                return true;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSortImage()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort_order', $post['newIndex']], ['<', 'sort_order', $post['oldIndex']]];
                $counter = 1;
            } else {
                $param = ['and', ['<=', 'sort_order', $post['newIndex']], ['>', 'sort_order', $post['oldIndex']]];
                $counter = -1;
            }
            SystemFiles::updateAllCounters(['sort_order' => $counter], [
                'and', ['attachment_type' => 'partners'], $param
            ]);
            SystemFiles::updateAll(['sort_order' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionSlider()
    {
        $images = SystemFiles::find()->where(['attachment_type' => 'slide'])->orderBy('sort_order')->all();
        //debug($images); die();
        $imagesLinks = $this->slidesPreview($images);
        $imagesLinksData = $this->slidesLinksData($images);
        if (Yii::$app->request->post()) {
            return $this->redirect(['index']);
        }
        return $this->render('slider', [
            'images' => $images,
            'imagesLinks' => $imagesLinks,
            'imagesLinksData' => $imagesLinksData,
        ]);
    }

    private function slidesPreview($imgs)
    {
        $Preview = [];
        foreach ($imgs as $img) {
            $Preview[] = Html::a(Html::img($img->imgSrc), ['/system-files/update-slide', 'id' => $img->id], ['class' => 'modal-form size-middle']);
        }
        return $Preview;
    }

    private function slidesLinksData($imgs)
    {
        return ArrayHelper::toArray($imgs, [
                SystemFiles::className() => [
                    'caption' => function ($imgs) {
                        $title = $imgs->title ? $imgs->title : $imgs->file_name;
                        return $title;
                    },
                    'key' => 'id',
                ]]
        );
    }

    public function actionUploadSlide()
    {
        $files = UploadedFile::getInstancesByName('Images');
        if (!empty($files) && count($files>0)) {
            $file = $files[0];
            $file_size = $file->size;
            $content_type = $file->type;
            $file_name = $file->name;
            $disk_name = SystemFiles::getDiskName($file);
            $path = Yii::getAlias('@uploads') . '/' . SystemFiles::getPartitionDirectory($disk_name);
            FileHelper::createDirectory($path);
            $file->saveAs($path . DIRECTORY_SEPARATOR . $disk_name);

            $image = new SystemFiles();
            $image->attachment_type = 'slide';
            $image->file_name = $file_name;
            $image->disk_name = $disk_name;
            $image->file_size = $file_size;
            $image->content_type = $content_type;
            $image->sort_order = SystemFiles::find()->where(['attachment_type' => 'slide'])->count();
            if ($image->save()) {
                $preview[] = Html::a(Html::img($image->imgSrc), ['/system-files/update-slide', 'id' => $image->id], ['class' => 'modal-form  size-middle']);
                $config[] = [
                    'caption' => $image->file_name,
                    'key' => $image->id,
                ];
                $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config];
                return json_encode($out);
            }
        } else {
            return false;
        }
    }

    public function actionDeleteSlide()
    {
        if(($model = SystemFiles::findOne(Yii::$app->request->post('key'))) && $model->delete()){
            SystemFiles::updateAllCounters(['sort_order' => -1], [
                'and', ['attachment_type' => 'slide'], ['>','sort_order', $model->sort_order ]
            ]);
            return true;
        } else {
            throw new NotFoundHttpException('Изображение не удалено');
        }
    }


    public function actionSortSlide()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort_order', $post['newIndex']], ['<', 'sort_order', $post['oldIndex']]];
                $counter = 1;
            } else {
                $param = ['and', ['<=', 'sort_order', $post['newIndex']], ['>', 'sort_order', $post['oldIndex']]];
                $counter = -1;
            }
            SystemFiles::updateAllCounters(['sort_order' => $counter], [
                'and', ['attachment_type' => 'slide'], $param
            ]);
            SystemFiles::updateAll(['sort_order' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }



}
