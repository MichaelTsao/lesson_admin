<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Teacher;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teachers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Teacher'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'teacher_id',
            'name',
            'phone',
            [
                'attribute' => 'status',
                'value' => function ($data, $row) {
                    return isset(Teacher::$statuses[$data['status']]) ? Teacher::$statuses[$data['status']] : '未知';
                },
                'filter' => Teacher::$statuses,
            ],
            'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
