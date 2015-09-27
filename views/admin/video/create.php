<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var wolfguard\video_gallery\models\VideoGallery $video_gallery
 * @var wolfguard\video_gallery\models\VideoGalleryItem $model
 */

$this->title = Yii::t('video_gallery', 'Create video');
$this->params['breadcrumbs'][] = ['label' => Yii::t('video_gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $video_gallery->name, 'url' => ['update', 'id' => $video_gallery->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('video_gallery', 'Videos'), 'url' => ['videos', 'id' => $video_gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('/admin/flash') ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => 255, 'autofocus' => true])->hint(Yii::t('video_gallery', 'Only latin characters, numbers and symbols (.-_) allowed. Spaces not allowed.')) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'sort')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'description')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('video_gallery', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
