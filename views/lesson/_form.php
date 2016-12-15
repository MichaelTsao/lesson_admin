<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Lesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList(\app\models\Lesson::$statuses) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'coverFile')->fileInput() ?>
        </div>
        <div class="col-md-10">
            <?php if ($model->cover): ?>
                <?= \yii\bootstrap\Html::img(Yii::$app->params['imageHost'] . $model->cover, ['height' => 80]); ?>
            <?php else: ?>
                <br/><b>未设置封面</b>
            <?php endif ?>
        </div>
    </div>

    <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <div class="row form-group">
        <div class="col-md-12">

            <?= Html::activeHiddenInput($model, 'teachers') ?>

            <b>导师：</b>
            <?php
            echo AutoComplete::widget([
                'name' => 'teacher',
                'id' => 'teacher',
                'options' => [
                    'placeholder' => '输入手机号、姓名或ID',
                ],
                'clientOptions' => [
                    'source' => \app\models\Teacher::find()
                        ->select(['name' => new \yii\db\Expression("CONCAT(name, ' ', phone, ' ', teacher_id)")])
                        ->asArray()
                        ->column(),
                ],
            ]);
            ?>
            &nbsp;
            <span id="teacher-list">
                <?php foreach (json_decode($model->teachers, true) as $item): ?>
                    <span style="cursor: pointer" class="label label-primary" onclick='remove_teacher(this)'
                          id="<?= $item ?>">
                        <?= \app\models\Teacher::findOne($item)->name ?>
                    </span>&nbsp;
                <?php endforeach; ?>
            </span>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                if (event.target.id == "teacher"){
                    add();
                }
                event.preventDefault();
                return false;
            }
        });
');
?>

<script>
    function add() {
        var teacher = $('#teacher');
        var param = teacher.val().split(' ');
        if (param.length == 3) {
            var teacher_name = param[0];
            var teacher_id = param[2];
            var teachers_json = $('#lesson-teachers');
            var teachers = $.parseJSON(teachers_json.val());

            if ($.inArray(teacher_id, teachers) == -1) {
                var item = "<span style='cursor: pointer' class='label label-primary' onclick='remove_teacher(this)' id='" + teacher_id + "'>"
                    + teacher_name + "</span>\n";
                $("#teacher-list").append(item);

                teachers.push(teacher_id);
                teachers_json.val(JSON.stringify(teachers));
            }
            teacher.val('');
        }
    }

    function remove_teacher(e) {
        var teachers_json = $('#lesson-teachers');
        var teachers = $.parseJSON(teachers_json.val());

        teachers = $.grep(teachers, function (value) {
            return value != $(e).attr('id');
        });
        teachers_json.val(JSON.stringify(teachers));

        $(e).remove();
    }
</script>