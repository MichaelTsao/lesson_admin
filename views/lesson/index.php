<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \app\models\Lesson;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lessons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Lesson'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'lesson_id',
            'ctime',
            'name',
            'price',
            [
                'attribute' => 'status',
                'value' => function ($data, $row) {
                    return isset(Lesson::$statuses[$data['status']]) ? Lesson::$statuses[$data['status']] : '未知';
                },
                'filter' => Lesson::$statuses,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {update-ware}',
                'buttons' => [
                    'update-ware' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-book"></span>',
                            \yii\helpers\Url::to(['update-ware', 'id' => $model->lesson_id]),
                            [
                                'title' => '编辑课件',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
