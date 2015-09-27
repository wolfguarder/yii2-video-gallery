<?php

namespace wolfguard\video_gallery\widgets;

use wolfguard\video_gallery\helpers\ModuleTrait;
use wolfguard\video_gallery\models\VideoGalleryItem;
use yii\base\Widget;

/**
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class VideoCode extends Widget
{
    use ModuleTrait;

    public $code;
    public $link;

    /**
     * @var bool
     */
    public $visible = true;

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();

        if(empty($this->code)) $this->visible = false;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if(!$this->visible) return false;

        $video = $this->module->manager->findVideoGalleryItemByCode($this->code);

        if(empty($video) || empty($video->url)) return false;

        $code = $video->getVideoCode();

        return $code ? : false;
    }
}