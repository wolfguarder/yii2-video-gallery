<?php

namespace wolfguard\video_gallery\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AdminController allows you to administrate video galleries.
 *
 * @property \wolfguard\video_gallery\Module $module
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com
 */
class AdminController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['post'],
                    'delete-video'  => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index', 'create', 'update', 'delete',
                            'videos', 'create-video', 'delete-video', 'update-video'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all VideoGallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = $this->module->manager->createVideoGallerySearch();
        $dataProvider = $searchModel->search($_GET);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Creates a new VideoGallery model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->module->manager->createVideoGallery(['scenario' => 'create']);

        $model->loadDefaultValues();

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video gallery has been created'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing VideoGallery model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if(\Yii::$app->request->get('returnUrl')){
                $back = urldecode(\Yii::$app->request->get('returnUrl'));
                return $this->redirect($back);
            }

            \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video gallery has been updated'));
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing VideoGallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video gallery has been deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the VideoGallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer                    $id
     * @return \wolfguard\video_gallery\models\VideoGallery the loaded model
     * @throws NotFoundHttpException      if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = $this->module->manager->findVideoGalleryById($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $model;
    }


    /**
     * Lists all VideoGallery videos models.
     *
     * @param $id VideoGallery id
     * @return mixed
     */
    public function actionVideos($id)
    {
        $video_gallery = $this->findModel($id);

        $searchModel  = $this->module->manager->createVideoGalleryItemSearch();
        $dataProvider = $searchModel->search($_GET, $id);

        return $this->render('video/index', [
            'video_gallery' => $video_gallery,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Create video_gallery video
     * @param $id VideoGallery id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCreateVideo($id)
    {
        $video_gallery = $this->findModel($id);

        $model = $this->module->manager->createVideoGalleryItem(['scenario' => 'create']);

        $model->loadDefaultValues();

        if ($model->load(\Yii::$app->request->post())) {
            $model->video_gallery_id = $video_gallery->id;
            if($model->create()) {
                \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video has been created'));
                return $this->redirect(['videos', 'id' => $id]);
            }
        }

        return $this->render('video/create', [
            'video_gallery' => $video_gallery,
            'model' => $model
        ]);
    }

    /**
     * Updates an existing VideoGalleryItem model.
     * If update is successful, the browser will be redirected to the 'videos' page.
     *
     * @param  integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdateVideo($id)
    {
        $model = $this->module->manager->findVideoGalleryItemById($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested video does not exist');
        }
        $model->scenario = 'update';

        $video_gallery = $this->findModel($model->video_gallery_id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if(\Yii::$app->request->get('returnUrl')){
                $back = urldecode(\Yii::$app->request->get('returnUrl'));
                return $this->redirect($back);
            }

            \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video has been updated'));
            return $this->refresh();
        }

        return $this->render('video/update', [
            'model' => $model,
            'video_gallery' => $video_gallery
        ]);
    }

    /**
     * Deletes an existing VideoGalleryItem model.
     * If deletion is successful, the browser will be redirected to the 'videos' page.
     *
     * @param  integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDeleteVideo($id)
    {
        $model = $this->module->manager->findVideoGalleryItemById($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        $model->delete();

        \Yii::$app->getSession()->setFlash('video_gallery.success', \Yii::t('video_gallery', 'Video has been deleted'));

        return $this->redirect(['videos', 'id' => $model->video_gallery_id]);
    }
}
