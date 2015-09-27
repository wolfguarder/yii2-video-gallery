<?php

namespace wolfguard\video_gallery\helpers;

/**
 * @property \wolfguard\video_gallery\Module $module
 */
trait ModuleTrait
{
    /**
     * @var null|\wolfguard\video_gallery\Module
     */
    private $_module;

    /**
     * @return null|\wolfguard\video_gallery\Module
     */
    protected function getModule()
    {
        if ($this->_module == null) {
            $this->_module = \Yii::$app->getModule('video_gallery');
        }

        return $this->_module;
    }
}