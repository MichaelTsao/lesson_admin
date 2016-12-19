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

<div class="row form-group vertical-center">

    <div class="col-md-1" style="text-align: right">
        <span class="glyphicon glyphicon-menu-hamburger"></span>
    </div>

    <div class="col-md-9">
        <?= Html::activeTextInput($point, 'name', [
            'name' => 'Chapter[' . $chapter->primaryKey . '][list][' . $point->primaryKey . '][name]',
            'class' => 'form-control',
        ]); ?>
    </div>

    <div class="col-md-2" style="text-align: center">
        <?= Html::button('删除', ['class' => 'btn btn-danger', 'onclick' => '']) ?>
        &nbsp;
        <?= Html::button('编辑课件', ['class' => 'btn btn-warning', 'onclick' => '']) ?>
    </div>

</div>
