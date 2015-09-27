<?php

namespace wolfguard\video_gallery\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\log\Logger;
use Yii;
use yiidreamteam\upload\VideoUploadBehavior;

/**
 * VideoGalleryItem ActiveRecord model.
 *
 * Database fields:
 * @property integer $id
 * @property integer $video_gallery_id
 * @property string  $code
 * @property string  $url
 * @property string  $title
 * @property string  $description
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property VideoGallery $video_gallery
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class VideoGalleryItem extends ActiveRecord
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'video_gallery_id'    => \Yii::t('video_gallery', 'Video gallery'),
            'code'         => \Yii::t('video_gallery', 'Code'),
            'url'          => \Yii::t('video_gallery', 'Video url'),
            'title'        => \Yii::t('video_gallery', 'Title'),
            'description'  => \Yii::t('video_gallery', 'Description'),
            'sort'         => \Yii::t('video_gallery', 'Sort index'),
            'created_at'   => \Yii::t('video_gallery', 'Created at'),
            'updated_at'   => \Yii::t('video_gallery', 'Updated at'),
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
            'create'   => ['code', 'video_gallery_id', 'url', 'title', 'description', 'sort'],
            'update'   => ['code', 'video_gallery_id', 'url', 'title', 'description', 'sort'],
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

            ['video_gallery_id', 'required'],

            ['url', 'required'],
            ['url', 'url'],
            ['url', 'string', 'max' => 255],
            ['url', 'trim'],

            ['sort', 'integer'],
            ['sort', 'trim'],

            ['title', 'string', 'max' => 255],
            ['title', 'trim'],

            ['description', 'safe'],
        ];
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing object');
        }

        if ($this->save()) {
            \Yii::getLogger()->log('Video gallery image has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating video gallery image', Logger::LEVEL_ERROR);

        return false;
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%video_gallery_item}}';
    }

    public function getVideoGallery()
    {
        return $this->hasOne(VideoGallery::className(), ['id' => 'video_gallery_id']);
    }

    public function getVideoCode(){
        if (strpos($this->url, 'youtu') !== false) {
            if (preg_match('/\/([0-9a-zA-Z\-_]+)$/', $this->url, $matches)) {
                return $matches[1];
            }
        }
        if(strpos($this->url, 'vimeo') !== false){
            if (preg_match('/\/([0-9a-zA-Z\-_]+)$/', $this->url, $matches)) {
                return $matches[1];
            }
        }

        return '';
    }

    /**
     * Gets video thumbnail from outside server
     * @param string $version (max, hq, mq, sd or default)
     * @return string Url to image
     */
    public function getVideoImage($version = 'default'){
        if (strpos($this->url, 'youtu') !== false) {
            switch($version){
                case 'max':
                    return 'https://img.youtube.com/vi/'.$this->getVideoCode().'/maxresdefault.jpg';
                    break;

                case 'hq':
                    return 'https://img.youtube.com/vi/'.$this->getVideoCode().'/hqdefault.jpg';
                    break;

                case 'mq':
                    return 'https://img.youtube.com/vi/'.$this->getVideoCode().'/mqdefault.jpg';
                    break;

                case 'sd':
                    return 'https://img.youtube.com/vi/'.$this->getVideoCode().'/sddefault.jpg';
                    break;

                default:
                    return 'https://img.youtube.com/vi/'.$this->getVideoCode().'/default.jpg';
            }
        }

        return '';
    }
}
