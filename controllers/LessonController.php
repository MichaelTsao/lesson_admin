<?php

namespace app\controllers;

use app\models\Content;
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
        $lesson = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            if ($chaptersPost = Yii::$app->request->post('Chapter')) {
                $chapters = [];
                foreach ($chaptersPost as $chapterId => $chapterInfo) {
                    $chapter = Section::get($chapterId, Section::TYPE_CHAPTER);
                    $chapter->attributes = $chapterInfo;

                    $points = [];
                    if (isset($chapterInfo['children'])) {
                        foreach ($chapterInfo['children'] as $pointId => $pointInfo) {
                            $point = Section::get($pointId, Section::TYPE_POINT);
                            $point->attributes = $pointInfo;
                            $points[] = $point;
                        }
                    }
                    $chapter->children = $points;

                    $chapters[] = $chapter;
                }
                $lesson->children = $chapters;

                if ($lesson->save()) {
//                    return $this->redirect(['view', 'id' => $lesson->lesson_id]);
                }
            }
        }

        return $this->render('update-ware', [
            'lesson' => $lesson,
        ]);
    }

    public function actionSetWare()
    {
        $pointId = Yii::$app->request->post('current-point-id');
        $point = Section::findOne($pointId);

        if ($sectionPost = Yii::$app->request->post('Section')) {
            $sections = [];
            foreach ($sectionPost as $sectionId => $sectionInfo) {
                $section = Section::get($sectionId, Section::TYPE_SECTION);
                $section->attributes = $sectionInfo;

                $contents = [];
                if (isset($sectionInfo['children'])) {
                    foreach ($sectionInfo['children'] as $contentId => $contentInfo) {
                        $content = Content::get($contentId, $contentInfo['type']);
                        $content->attributes = $contentInfo;
                        $content->setFile('Section[' . $sectionId . '][children][' . $contentId . '][file]');
                        $contents[] = $content;
                    }
                }
                $section->children = $contents;

                $sections[] = $section;
            }
            $point->children = $sections;

            if ($point->save()) {
                return 'ok';
            }
        }

        return $this->renderPartial('ware', ['point' => $point]);
    }

    public function actionWare($id)
    {
        $point = Section::get($id, Section::TYPE_POINT);

        return $this->renderPartial('ware', ['point' => $point]);
    }

    public function actionNewChapter()
    {
        $chapter = Section::create(Section::TYPE_CHAPTER);

        $sort = new Sortable([
            'items' => [$this->renderPartial('chapter', ['chapter' => $chapter])],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);

        return $sort->renderItems();
    }

    public function actionNewPoint($id)
    {
        $chapter = Section::get($id, Section::TYPE_CHAPTER);
        $point = Section::create(Section::TYPE_POINT);

        $sort = new Sortable([
            'items' => [$this->renderPartial('point', ['chapter' => $chapter, 'point' => $point])],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);

        return $sort->renderItems();
    }

    public function actionNewSection($id)
    {
        $point = Section::get($id, Section::TYPE_POINT);
        $section = Section::create(Section::TYPE_SECTION);

        $sort = new Sortable([
            'items' => [$this->renderPartial('section', ['point' => $point, 'section' => $section])],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);

        return $sort->renderItems();
    }

    public function actionNewContent($id, $type)
    {
        $section = Section::get($id, Section::TYPE_SECTION);
        $content = Content::create($type);

        $sort = new Sortable([
            'items' => [$this->renderPartial('content', ['content' => $content, 'section' => $section])],
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
