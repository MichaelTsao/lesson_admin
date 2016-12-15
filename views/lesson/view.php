<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\Lesson;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->lesson_id], ['class' => 'btn btn-primary']) ?>
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
            'chapters',
            [
                'attribute' => 'status',
                'value' => isset(Lesson::$statuses[$model->status]) ? Lesson::$statuses[$model->status] : '未知',
            ],
            'ctime',
        ],
    ]) ?>

</div>
