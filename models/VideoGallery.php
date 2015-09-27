<?php

namespace wolfguard\video_gallery\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\log\Logger;
use Yii;

/**
 * VideoGallery ActiveRecord model.
 *
 * Database fields:
 * @property integer $id
 * @property string  $code
 * @property string  $name
 * @property string  $description
 * @property integer  $sort
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property VideoGalleryItem[] $videos
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class VideoGallery extends ActiveRecord
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'code'          => \Yii::t('video_gallery', 'Code'),
            'name'          => \Yii::t('video_gallery', 'Name'),
            'description'   => \Yii::t('video_gallery', 'Description'),
            'sort'          => \Yii::t('video_gallery', 'Sort index'),
            'created_at'    => \Yii::t('video_gallery', 'Created at'),
            'updated_at'    => \Yii::t('video_gallery', 'Updated at'),
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'create'   => ['name', 'code', 'description', 'sort'],
            'update'   => ['name', 'code', 'description', 'sort'],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // code rules
            ['code', 'required', 'on' => ['create', 'update']],
            ['code', 'match', 'pattern' => '/^[0-9a-zA-Z\_\.\-]+$/'],
            ['code', 'string', 'min' => 3, 'max' => 255],
            ['code', 'unique'],
            ['code', 'trim'],

            // name rules
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'trim'],

            ['sort', 'integer'],
            ['sort', 'trim'],
        ];
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing object');
        }

        if ($this->save()) {
            \Yii::getLogger()->log('Video gallery has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating video gallery', Logger::LEVEL_ERROR);

        return false;
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%video_gallery}}';
    }

    public function getVideos()
    {
        return $this->hasMany(VideoGalleryItem::className(), ['video_gallery_id' => 'id']);
    }
}
