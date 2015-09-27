<?php

/**
 * @var yii\web\View $this
 */

?>

<?php if (Yii::$app->getSession()->hasFlash('video_gallery.success')): ?>
    <div class="alert alert-success">
        <p><?= Yii::$app->getSession()->getFlash('video_gallery.success') ?></p>
    </div>
<?php endif; ?>

<?php if (Yii::$app->getSession()->hasFlash('video_gallery.error')): ?>
    <div class="alert alert-danger">
        <p><?= Yii::$app->getSession()->getFlash('video_gallery.error') ?></p>
    </div>
<?php endif; ?>