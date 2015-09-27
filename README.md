Video galleries
===========
Yii2 module for video galleries with groups (YouTube, Vimeo)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist wolfguard/yii2-video-gallery "*"
```

or add

```
"wolfguard/yii2-video-gallery": "*"
```

to the require section of your `composer.json` file.

After running 

```
php composer.phar update
```

run

```
yii migrate --migrationPath=@vendor/wolfguard/yii2-video-gallery/migrations
```

After that change your main configuration file ```config/web.php```

```php
<?php return [
    ...
    'modules' => [
        ...
        'video_gallery' => [
            'class' => 'wolfguard\video_gallery\Module',
        ],
        ...
    ],
    ...
];
```


Usage
-----

Once the extension is installed, simply use it in your code by:

```php
<?= \wolfguard\video_gallery\widgets\VideoCode::widget(['code' => 'video-gallery-code']); ?>
```

or make your own widget to display single video or gallery!