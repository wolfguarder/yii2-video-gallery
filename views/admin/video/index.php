<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var wolfguard\video_gallery\models\VideoGalleryItemSearch $searchModel
 * @var wolfguard\video_gallery\models\VideoGallery $video_gallery
 */

$this->title = Yii::t('video_gallery', 'Manage videos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('video_gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $video_gallery->name, 'url' => ['update', 'id' => $video_gallery->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title). ': ' . $video_gallery->name ?> <?= Html::a(Yii::t('video_gallery', 'Create video'), ['create-video', 'id' => $video_gallery->id], ['class' => 'btn btn-success']) ?></h1>

<?php echo $this->render('/admin/flash') ?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        'title',
        'url',
        'sort',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return Yii::t('video_gallery', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
            },
            'filter' => false,
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update-video} {delete-video}',
            'buttons' => [
                'update-video' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                    ]);
                },
                'delete-video' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },
            ],
        ],
    ],
]); ?>
