<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var wolfguard\video_gallery\models\VideoGallerySearch $searchModel
 */

$this->title = Yii::t('video_gallery', 'Manage video galleries');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?> <?= Html::a(Yii::t('video_gallery', 'Create video gallery'), ['create'], ['class' => 'btn btn-success']) ?></h1>

<?php echo $this->render('flash') ?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        'name',
        'code',
        'sort',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::t('video_gallery', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
            },
            'filter' => false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
        [
            'attribute' => '',
            'format' => 'raw',
            'value' => function ($model) {
                return '<div><a href="'.\yii\helpers\Url::toRoute(['admin/videos', 'id' => $model->id]).'">'.Yii::t('video_gallery', 'Videos').'</a></div>';
            },
        ],
    ],
]); ?>
