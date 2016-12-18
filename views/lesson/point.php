<?php

use yii\bootstrap\Html;
use app\models\Section;
use mycompany\common\Logic;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/18
 * Time: 下午4:39
 *
 * @var $id int Point ID
 */

if (isset($id)) {
    $point = Section::findOne($id);
}else{
    $point = new Section();
    $point->section_id = Logic::makeID();
}
?>

<div class="row form-group vertical-center">

    <div class="col-md-1" style="text-align: right">
        <span class="glyphicon glyphicon-menu-hamburger"></span>
    </div>

    <div class="col-md-9">
        <?= Html::activeTextInput($point, 'name', [
            'name' => 'Point[' . $point->section_id . '][name]',
            'class' => 'form-control',
        ]); ?>
    </div>

    <div class="col-md-2" style="text-align: center">
        <?= Html::button('删除', ['class' => 'btn btn-danger', 'onclick' => '']) ?>
        &nbsp;
        <?= Html::button('编辑课件', ['class' => 'btn btn-warning', 'onclick' => '']) ?>
    </div>

</div>
