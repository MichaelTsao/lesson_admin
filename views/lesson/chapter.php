<?php

use yii\bootstrap\Html;
use yii\jui\Sortable;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/16
 * Time: 下午4:23
 *
 * @var $chapter \app\models\Section Chapter Model
 * @var $this yii\web\View
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row vertical-center">
            <div class="col-md-1" style="text-align: right">
                课名 :
            </div>
            <div class="col-md-11">
                <?= Html::activeTextInput($chapter, 'name', [
                    'name' => 'Chapter[' . $chapter->primaryKey . '][name]',
                    'class' => 'form-control'
                ]); ?>

                <?php if ($chapter->errors): ?>
                    <span class="label label-danger"><?= array_values($chapter->firstErrors)[0]; ?></span>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="panel-body">

        <div class="row vertical-center">
            <div class="col-md-1" style="text-align: right">
                知识点 :
            </div>
            <div class="col-md-11">
                &nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                $points = [];

                foreach ($chapter->children as $point) {
                    $points[] = $this->render('point', ['point' => $point, 'chapter' => $chapter]);
                }

                echo Sortable::widget([
                    'items' => $points,
                    'options' => ['tag' => 'div'],
                    'itemOptions' => ['tag' => 'div'],
                    'clientOptions' => ['cursor' => 'move'],
                    'id' => 'point_list_' . $chapter->primaryKey,
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <?= Html::button('增加知识点', ['class' => 'btn btn-info', 'onclick' => 'newPoint("' . $chapter->primaryKey . '")']) ?>
                &nbsp;
                <?= Html::button('删除本课', ['class' => 'btn btn-danger', 'onclick' => '']) ?>
            </div>
        </div>

    </div>
</div>
