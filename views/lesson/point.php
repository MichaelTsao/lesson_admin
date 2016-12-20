<?php

use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/18
 * Time: 下午4:39
 *
 * @var $point \app\models\Section Point Model
 * @var $chapter \app\models\Section Chapter Model
 */
?>

<div class="row form-group vertical-center" id="point-<?= $point->primaryKey ?>">

    <div class="col-md-1" style="text-align: right">
        <span class="glyphicon glyphicon-menu-hamburger"></span>
    </div>

    <div class="col-md-9">
        <?= Html::activeTextInput($point, 'name', [
            'name' => 'Chapter[' . $chapter->primaryKey . '][children][' . $point->primaryKey . '][name]',
            'class' => 'form-control',
            'id' => 'point-name-' . $point->primaryKey,
        ]); ?>

        <?php if ($point->errors): ?>
            <span class="label label-danger"><?= array_values($point->firstErrors)[0]; ?></span>
        <?php endif ?>
    </div>

    <div class="col-md-2" style="text-align: center">
        <?= Html::button('删除', [
            'class' => 'btn btn-danger',
            'onclick' => 'delPoint("' . $point->primaryKey . '")'
        ]) ?>
        &nbsp;
        <?= Html::button('编辑课件', [
            'class' => 'btn btn-warning',
            'onclick' => 'showWare("' . $point->primaryKey . '")',
            'data-toggle' => 'modal',
            'data-target' => '#warePanel'
        ]) ?>
    </div>

</div>
