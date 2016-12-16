<?php

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/16
 * Time: 下午4:23
 *
 * @var $id int Chapter ID
 */

$chapter = \app\models\Section::findOne($id);
?>

<div class="panel panel-default">
    <div class="panel-heading">课名: <?= $chapter->name ?></div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                知识点：
            </div>
        </div>

        <?php foreach (json_decode($chapter->children, true) as $item): ?>
            <div class="row">
                <div class="col-md-12">
                    <?= \app\models\Section::findOne($item)->name ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <?= Html::button('增加知识点', ['class' => 'btn btn-info', 'onclick' => '']) ?>
                &nbsp;
                <?= Html::button('删除本课', ['class' => 'btn btn-danger', 'onclick' => '']) ?>
            </div>
        </div>

    </div>
</div>
