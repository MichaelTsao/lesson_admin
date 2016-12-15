<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Teacher;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->teacher_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->teacher_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'teacher_id',
            'name',
            'phone',
            [
                'attribute' => 'status',
                'value' => isset(Teacher::$statuses[$model->status]) ? Teacher::$statuses[$model->status] : '未知',
            ],
            'ctime',
        ],
    ]) ?>

</div>
