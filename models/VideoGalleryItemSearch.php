<?php

namespace wolfguard\video_gallery\models;

use wolfguard\video_gallery\helpers\ModuleTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VideoGalleryItemSearch represents the model behind the search form about VideoGallery.
 */
class VideoGalleryItemSearch extends Model
{
    use ModuleTrait;

    /**
     * @var integer
     */
    public $video_gallery_id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $sort;

    /**
     * @var string
     */
    public $code;

    /**
     * @var integer
     */
    public $created_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_gallery_id', 'created_at', 'sort'], 'integer'],
            [['url', 'title', 'sort', 'code'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'video_gallery_id' => \Yii::t('video_gallery', 'Video gallery'),
            'url' => \Yii::t('video_gallery', 'Video url'),
            'code' => \Yii::t('video_gallery', 'Code'),
            'title' => \Yii::t('video_gallery', 'Title'),
            'sort' => \Yii::t('video_gallery', 'Sort index'),
            'created_at' => \Yii::t('video_gallery', 'Created at'),
        ];
    }

    /**
     * @param $params
     * @param $video_gallery_id
     * @return ActiveDataProvider
     */
    public function search($params, $video_gallery_id)
    {
        $query = $this->module->manager->createVideoGalleryItemQuery()->where(['video_gallery_id' => $video_gallery_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'video_gallery_id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'code', true);
        $this->addCondition($query, 'url', true);
        $this->addCondition($query, 'sort');
        $this->addCondition($query, 'created_at');

        return $dataProvider;
    }

    /**
     * @param $query
     * @param $attribute
     * @param bool $partialMatch
     */
    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
