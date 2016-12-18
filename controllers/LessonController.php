<?php

namespace app\controllers;

use app\models\Section;
use mycompany\common\Logic;
use Yii;
use app\models\Lesson;
use app\models\LessonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\jui\Sortable;

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Lesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lesson model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post())) {
            $model->setCover();
            if ($model->save()) {
                $model->saveCover();
                return $this->redirect(['view', 'id' => $model->lesson_id]);
            }
            Yii::warning($model->errors);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->setCover();
            if ($model->save()) {
                $model->saveCover();
                return $this->redirect(['view', 'id' => $model->lesson_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateWare($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($chapters = Yii::$app->request->post('Chapter') && $points = Yii::$app->request->post('Point')) {
                foreach ($points as $chapter_id => $point) {
                    $point_list = array_keys($point);
                    foreach ($point as $point_id => $item) {
                        if (!$point_model = Section::findOne($point_id)) {
                            $point_model = Section::create();
                        }
                        $point_model->setAttributes($item);
                        if (!$point_model->save()) {
                        }
                    }
                }
            }
        }

        return $this->render('update-ware', [
            'model' => $model,
        ]);
    }

    public function actionNewChapter()
    {
        $sort = new Sortable([
            'items' => [$this->renderPartial('chapter')],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        return $sort->renderItems();

    }

    public function actionNewPoint($id)
    {
        $sort = new Sortable([
            'items' => [$this->renderPartial('point', ['chapter_id' => $id])],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        return $sort->renderItems();

    }

    /**
     * Deletes an existing Lesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
