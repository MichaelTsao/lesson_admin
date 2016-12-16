<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */

$this->title = Yii::t('app', 'Update Ware') . '：' . $model->name . ' - ' . $model->lesson_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->lesson_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Ware');
?>
<div class="lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

</div>