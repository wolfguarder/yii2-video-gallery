<?php

namespace wolfguard\video_gallery;

use yii\base\Component;

/**
 * ModelManager is used in order to create models and find galleries.
 *
 * @method models\VideoGallery               createVideoGallery
 * @method models\VideoGallerySearch         createVideoGallerySearch
 *
 * @method models\VideoGalleryItem               createVideoGalleryItem
 * @method models\VideoGalleryItemSearch         createVideoGalleryItemSearch
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class ModelManager extends Component
{
    /** @var string */
    public $videoGalleryClass = 'wolfguard\video_gallery\models\VideoGallery';

    /** @var string */
    public $videoGallerySearchClass = 'wolfguard\video_gallery\models\VideoGallerySearch';

    /** @var string */
    public $videoGalleryItemClass = 'wolfguard\video_gallery\models\VideoGalleryItem';

    /** @var string */
    public $videoGalleryItemSearchClass = 'wolfguard\video_gallery\models\VideoGalleryItemSearch';

    /**
     * Finds a video_gallery by the given id.
     *
     * @param  integer $id VideoGallery id to be used on search.
     * @return models\VideoGallery
     */
    public function findVideoGalleryById($id)
    {
        return $this->findVideoGallery(['id' => $id])->one();
    }

    /**
     * Finds a video_gallery image by the given id.
     *
     * @param  integer $id VideoGalleryItem id to be used on search.
     * @return models\VideoGalleryItem
     */
    public function findVideoGalleryItemById($id)
    {
        return $this->findVideoGalleryItem(['id' => $id])->one();
    }

    /**
     * Finds a video_gallery by the given code.
     *
     * @param  string $code Code to be used on search.
     * @return models\VideoGallery
     */
    public function findVideoGalleryByCode($code)
    {
        return $this->findVideoGallery(['code' => $code])->one();
    }

    /**
     * Finds a video by the given code.
     *
     * @param  string $code Code to be used on search.
     * @return models\VideoGalleryItem
     */
    public function findVideoGalleryItemByCode($code)
    {
        return $this->findVideoGalleryItem(['code' => $code])->one();
    }

    /**
     * Finds a video_gallery by the given condition.
     *
     * @param  mixed $condition Condition to be used on search.
     * @return \yii\db\ActiveQuery
     */
    public function findVideoGallery($condition)
    {
        return $this->createVideoGalleryQuery()->where($condition);
    }

    /**
     * Finds a video_gallery image by the given condition.
     *
     * @param  mixed $condition Condition to be used on search.
     * @return \yii\db\ActiveQuery
     */
    public function findVideoGalleryItem($condition)
    {
        return $this->createVideoGalleryItemQuery()->where($condition);
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed|object
     */
    public function __call($name, $params)
    {
        $property = (false !== ($query = strpos($name, 'Query'))) ? mb_substr($name, 6, -5) : mb_substr($name, 6);
        $property = lcfirst($property) . 'Class';
        if ($query) {
            return forward_static_call([$this->$property, 'find']);
        }
        if (isset($this->$property)) {
            $config = [];
            if (isset($params[0]) && is_array($params[0])) {
                $config = $params[0];
            }
            $config['class'] = $this->$property;
            return \Yii::createObject($config);
        }

        return parent::__call($name, $params);
    }
}