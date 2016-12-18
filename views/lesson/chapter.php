<?php

use yii\bootstrap\Html;
use yii\jui\Sortable;
use app\models\Section;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/16
 * Time: 下午4:23
 *
 * @var $id int Chapter ID
 * @var $this yii\web\View
 */

$points = [];
if (isset($id)) {
    $chapter = Section::findOne($id);
    foreach (\app\models\Tree::children($id) as $item) {
        $points[] = $this->render('point', ['id' => $item, 'chapter_id' => $id]);
    }
} else {
    $chapter = Section::create();
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row vertical-center">
            <div class="col-md-1" style="text-align: right">
                课名 :
            </div>
            <div class="col-md-11">
                <?= Html::activeTextInput($chapter, 'name', [
                    'name' => 'Chapter[' . $chapter->section_id . '][name]',
                    'class' => 'form-control'
                ]); ?>

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
                echo Sortable::widget([
                    'items' => $points,
                    'options' => ['tag' => 'div'],
                    'itemOptions' => ['tag' => 'div'],
                    'clientOptions' => ['cursor' => 'move'],
                    'id' => 'point_list_' . $chapter->section_id,
                ]);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <?= Html::button('增加知识点', ['class' => 'btn btn-info', 'onclick' => 'newPoint("' . $chapter->section_id . '")']) ?>
                &nbsp;
                <?= Html::button('删除本课', ['class' => 'btn btn-danger', 'onclick' => '']) ?>
            </div>
        </div>

    </div>
</div>
