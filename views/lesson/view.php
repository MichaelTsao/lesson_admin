<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\Lesson;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$teacherStr = '';
foreach (json_decode($model->teachers, true) as $item) {
    $teacherStr .= '<span class="label label-primary">' . \app\models\Teacher::findOne($item)->name . "</span>&nbsp;";
}
?>
<div class="lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->lesson_id], ['class' => 'btn btn-primary']) ?>
        &nbsp;
        <?= Html::a(Yii::t('app', 'Update Ware'), ['update-ware', 'id' => $model->lesson_id], ['class' => 'btn btn-warning']) ?>
        <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->lesson_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => "<tr><th style='width: 86px'>{label}</th><td>{value}</td></tr>",
        'attributes' => [
            'lesson_id',
            'name',
            'price',
            'intro',
            'details:ntext',
            [
                'attribute' => 'cover',
                'value' => \yii\bootstrap\Html::img(Yii::$app->params['imageHost'] . $model->cover, ['height' => 150]),
                'format' => 'html',
            ],
            [
                'attribute' => 'teachers',
                'value' => $teacherStr,
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'value' => isset(Lesson::$statuses[$model->status]) ? Lesson::$statuses[$model->status] : '未知',
            ],
            'ctime',
        ],
    ]) ?>

</div>
