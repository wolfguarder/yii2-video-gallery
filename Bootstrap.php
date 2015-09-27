<?php

namespace wolfguard\video_gallery;

use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

/**
 * Bootstrap class registers module and block application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (!$app->hasModule('video_gallery')) {
            $app->setModule('video_gallery', [
                'class' => 'wolfguard\video_gallery\Module'
            ]);
        }

        /** @var $module Module */
        $module = $app->getModule('video_gallery');

        if ($app instanceof \yii\console\Application) {
            $module->controllerNamespace = 'wolfguard\video_gallery\commands';
        } else {
            $configUrlRule = [
                'prefix' => $module->urlPrefix,
                'rules'  => $module->urlRules
            ];

            if ($module->urlPrefix != 'video_gallery') {
                $configUrlRule['routePrefix'] = 'video_gallery';
            }

            $app->get('urlManager')->rules[] = new GroupUrlRule($configUrlRule);
        }

        $app->get('i18n')->translations['video_gallery*'] = [
            'class'    => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
        ];
    }
}