<?php

use yii\helpers\Html;
use yii\jui\Sortable;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $lesson app\models\Lesson */

$this->title = Yii::t('app', 'Update Ware') . '：' . $lesson->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $lesson->name, 'url' => ['view', 'id' => $lesson->lesson_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Ware');
?>
<div class="lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="margin: 20px">
        <?php
        $chapters = [];

        foreach ($lesson->children as $chapter) {
            $chapters[] = $this->render('chapter', ['chapter' => $chapter]);
        }

        echo Sortable::widget([
            'items' => $chapters,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'chapter_list',
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::button('增加新课', ['class' => 'btn btn-success', 'onclick' => 'newChapter()']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function newChapter() {
        $.get('<?= \yii\helpers\Url::to(['new-chapter'])?>', function (data) {
            $('#chapter_list').append(data);
        });
    }

    function newPoint(id) {
        $.get('<?= \yii\helpers\Url::to(['new-point'])?>?id=' + id, function (data) {
            var list = $('#point_list_' + id);
            list.append(data);
            list.addClass('ui-sortable');
            list.sortable({"cursor": "move"});
        });
    }

    function delChapter() {

    }
</script>