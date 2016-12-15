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

    <div class="row">
        <?= $form->field($model, 'chapters')->widget(\yii\jui\AutoComplete::classname(), [
            'options' => [
                'placeholder' => '导师的手机号或名字',
            ],
            'clientOptions' => [
                'source' => \app\models\Teacher::find()
                    ->select(['name' => new \yii\db\Expression("CONCAT(phone, ' ', name)")])
                    ->asArray()
                    ->column(),
            ],
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
