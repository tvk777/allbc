<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Imagine\Image\Point;
use yii\imagine\Image;
use Imagine\Image\Box;


/**
 * This is the model class for table "system_files".
 *
 * @property int $id
 * @property string $disk_name
 * @property string $file_name
 * @property int $file_size
 * @property string $content_type
 * @property string $title
 * @property string $description
 * @property string $field
 * @property string $attachment_id
 * @property string $attachment_type
 * @property int $is_public
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property int $width
 * @property int $height
 */
class SystemFiles extends ActiveRecord
{
    public $attachment;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_files';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'file_size', 'content_type'], 'required'],
            [['file_size', 'is_public', 'sort_order', 'width', 'height', 'attachment_id'], 'integer'],
            [['description'], 'string'],
            [['attachment'], 'image'],
            [['created_at', 'updated_at'], 'safe'],
            [['disk_name', 'file_name', 'content_type', 'title', 'field', 'attachment_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'disk_name' => Yii::t('app', 'Disk Name'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_size' => Yii::t('app', 'File Size'),
            'content_type' => Yii::t('app', 'Content Type'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'field' => Yii::t('app', 'Field'),
            'attachment_id' => Yii::t('app', 'Attachment ID'),
            'attachment_type' => Yii::t('app', 'Attachment Type'),
            'is_public' => Yii::t('app', 'Is Public'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
        ];
    }

    public static function getDiskName($file)
    {
        $ext = $file->extension;
        //if(is_array ($file)){ $ext = $file[0]->extension; }
        $disk_name = str_replace('.', '', uniqid(null, true)) . '.' . $ext;
        return $disk_name;
    }

    public static function getPartitionDirectory($name)
    {
        return implode('/', array_slice(str_split($name, 3), 0, 3)) . '/';
    }

    protected function getImgSrc()
    {
        if ($this->disk_name === null)
            return false;

        $name = $this->disk_name;
        $dir0 = '/uploads/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';
        return $dir0 . $dir1 . $dir2 . $dir3 . $name;
    }

    protected function getImgPath()
    {
        $name = $this->disk_name;
        $dir0 = Yii::getAlias('@uploads') . '/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';

        return $dir0 . $dir1 . $dir2 . $dir3 . $name;
    }

    protected function getThumb300x200Src()
    {
        $name = $this->disk_name;
        $n = explode('.', $name);
        $ext = end($n);
        $thumb = 'thumb_' . $this->id . '_300_200_0_0_crop.' . $ext;
        $dir0 = '/uploads/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';

        return $dir0 . $dir1 . $dir2 . $dir3 . $thumb;
    }

    //avatar
    protected function getThumb260x260Src()
    {
        $name = $this->disk_name;
        $n = explode('.', $name);
        $ext = end($n);
        $thumb = 'thumb_' . $this->id . '_260_260_0_0_crop.' . $ext;
        $dir0 = '/uploads/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';

        return $dir0 . $dir1 . $dir2 . $dir3 . $thumb;
    }

    protected function getThumbSrc()
    {
        $name = $this->disk_name;
        $n = explode('.', $name);
        $ext = end($n);
        $thumb = 'thumb_' . $this->id . '.' . $ext;
        $dir0 = '/uploads/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';

        return $dir0 . $dir1 . $dir2 . $dir3 . $thumb;
    }

    protected function getImgDirs()
    {
        $name = $this->disk_name;
        $dirs = [];
        $dir0 = Yii::getAlias('@uploads') . '/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';
        $dirs[0] = $dir0 . $dir1 . $dir2 . $dir3;
        $dirs[1] = $dir0 . $dir1 . $dir2;
        $dirs[2] = $dir0 . $dir1;
        return $dirs;
    }


//надо вставить проверку существования директории перед удалением
    public function beforeDelete()
    {
        //debug($this); die();
        if (parent::beforeDelete()) {
            $dirs = self::getImgDirs();
            if (file_exists($dirs[0] . $this->disk_name)) {
                unlink($dirs[0] . $this->disk_name);
                FileHelper::removeDirectory($dirs[0]);
            }
            if (!FileHelper::findFiles($dirs[1])) {
                FileHelper::removeDirectory($dirs[1]);
            }
            if (!FileHelper::findFiles($dirs[2])) {
                FileHelper::removeDirectory($dirs[2]);
            }

            self::updateAllCounters(['sort_order' => -1],
                ['and',
                    ['=', 'attachment_id', $this->attachment_id],
                    ['=', 'attachment_type', $this->attachment_type],
                    ['>', 'sort_order', $this->sort_order],
                ]
            );
            return true;
        } else {
            return false;
        }
    }

    public static function getImagesLinks($imgs)
    {
        $images = [];
        foreach (ArrayHelper::getColumn($imgs, 'disk_name') as $img) {
            $dir0 = '/uploads/';
            $dir1 = substr($img, 0, 3) . '/';
            $dir2 = substr($img, 3, 3) . '/';
            $dir3 = substr($img, 6, 3) . '/';
            $images[] = $dir0 . $dir1 . $dir2 . $dir3 . $img;
        }

        return $images;
    }

    public static function getImagesLinksData($imgs)
    {
        return ArrayHelper::toArray($imgs, [
                self::className() => [
                    'caption' => 'disk_name',
                    'key' => 'id',
                ]]
        );
    }

    public static function uploadImage($file, $field, $allwoedFiles)
    {
        $ext = $file->extension;
        if ($allwoedFiles !== NULL) {
            $allwoedFiles = explode('-', $allwoedFiles);
        } else {
            $allwoedFiles = ['jpg', 'png', 'gif'];
        }
        if (!in_array($ext, $allwoedFiles)) {
            $error = 'Запрещенное расширение для файла. Только ' . implode($allwoedFiles, ', ') . ' разрешены.';
            return json_encode(['error' => $error]);
        }
        $disk_name = self::getDiskName($file);
        $path = Yii::getAlias('@uploads') . '/' . self::getPartitionDirectory($disk_name);
        FileHelper::createDirectory($path);
        if ($file->saveAs($path . DIRECTORY_SEPARATOR . $disk_name)) {
            $image = new SystemFiles();
            $image->file_name = $file->name;
            $image->disk_name = $disk_name;
            $image->file_size = $file->size;
            $image->field = $field;
            //$image->sort_order = $image->id;
            $image->content_type = $file->type;
            if ($image->save()) {
                $image->sort_order = $image->id;
                $preview[] = Html::a(Html::img($image->imgSrc), ['/system-files/update', 'id' => $image->id], ['class' => 'modal-form  size-middle']);
                $config[] = [
                    'caption' => $image->file_name,
                    'key' => $image->id,
                ];
                $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config];
                //var_dump(json_encode($out)); die();
                return json_encode($out);
                //return true;
            }
        } else {
            $error = 'Загрузка файла не удалась.';
            return json_encode(['error' => $error]);
        }
    }

    public static function sortImage($id)
    {
        $post = Yii::$app->request->post('sort');
        if ($post['oldIndex'] > $post['newIndex']) {
            $param = ['and', ['>=', 'sort_order', $post['newIndex']], ['<', 'sort_order', $post['oldIndex']]];
            $counter = 1;
        } else {
            $param = ['and', ['<=', 'sort_order', $post['newIndex']], ['>', 'sort_order', $post['oldIndex']]];
            $counter = -1;
        }
        self::updateAllCounters(['sort_order' => $counter], [
            'and', ['attachment_type' => 'post', 'attachment_id' => $id], $param
        ]);
        self::updateAll(['sort_order' => $post['newIndex']], [
            'id' => $post['stack'][$post['newIndex']]['key']
        ]);
    }

    public static function saveThumb($image, $maxWidth, $maxHeight, $background = 'fff', $thumbMidName = '')
    {
        $diskName = $image->disk_name;
        $midName = $thumbMidName !== '' ? '_' . $thumbMidName . '_' : '';
        $path = Yii::getAlias('@uploads') . '/' . SystemFiles::getPartitionDirectory($diskName);
        $originalImage = $path . DIRECTORY_SEPARATOR . $diskName;
        $size = getimagesize($originalImage);
        $originalWidth = $size[0];
        $originalHeight = $size[1];
        $name_arr = explode('.', $diskName);
        $extension = end($name_arr);
        $thumb_name = 'thumb_' . $midName . $image->id . '.' . $extension;
        $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND;
        if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
            /*Image::thumbnail($originalImage, $maxWidth, $maxHeight, $mode)
                ->save($path . DIRECTORY_SEPARATOR . $thumb_name, ['quality' => 100]);*/
            Image::getImagine()->open($originalImage)
                ->thumbnail(new Box($maxWidth, $maxHeight))
                ->save($path . DIRECTORY_SEPARATOR . $thumb_name, ['quality' => 80]);

        } else {
            Image::getImagine()->open($originalImage)
                ->thumbnail(new Box($originalWidth, $originalHeight))
                ->save($path . DIRECTORY_SEPARATOR . $thumb_name, ['quality' => 80, 'thumbnailBackgroundColor' => $background, 'thumbnailBackgroundAlpha' => 0]);
        }
    }


}
