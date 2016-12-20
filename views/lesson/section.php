<?php

use yii\bootstrap\Html;
use yii\jui\Sortable;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/20
 * Time: 下午7:11
 *
 * @var $section \app\models\Section Section Model
 */
?>

<div class="panel panel-default" id="section-<?= $section->primaryKey ?>">
    <div class="panel-heading">
        <div class="row vertical-center">
            <div class="col-md-2" style="text-align: right">
                段标题 :
            </div>
            <div class="col-md-10">
                <?= Html::activeTextInput($section, 'name', [
                    'name' => 'Section[' . $section->primaryKey . '][name]',
                    'class' => 'form-control'
                ]); ?>

                <?php if ($section->errors): ?>
                    <span class="label label-danger"><?= array_values($section->firstErrors)[0]; ?></span>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                <?php
                /*
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
                */
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <?= Html::button('添加讲解内容', ['class' => 'btn btn-info', 'onclick' => 'newContent("' . $section->primaryKey . '")']) ?>
                &nbsp;
                <?= Html::button('添加图片', ['class' => 'btn btn-primary', 'onclick' => 'newImage("' . $section->primaryKey . '")']) ?>
                &nbsp;
                <?= Html::button('删除本段', ['class' => 'btn btn-danger', 'onclick' => 'delSection("' . $section->primaryKey . '")']) ?>
            </div>
        </div>

    </div>
</div>
