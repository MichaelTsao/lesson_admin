<?php

use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/20
 * Time: 下午10:27
 *
 * @var $content \app\models\Content Content Model
 * @var $section \app\models\Section Section Model
 */
?>

<div class="row form-group vertical-center" id="content-<?= $content->primaryKey ?>">

    <div class="col-md-1" style="text-align: right">
        <span class="glyphicon glyphicon-menu-hamburger"></span>
    </div>

    <div class="col-md-9">
        <?= Html::activeTextInput($content, 'url', [
            'name' => 'Section[' . $section->primaryKey . '][children][' . $content->primaryKey . '][url]',
            'class' => 'form-control',
            'id' => 'content-url-' . $content->primaryKey,
        ]); ?>

        <?php if ($content->errors): ?>
            <span class="label label-danger"><?= array_values($content->firstErrors)[0]; ?></span>
        <?php endif ?>
    </div>

    <div class="col-md-2" style="text-align: center">
        <?= Html::button('删除', [
            'class' => 'btn btn-danger',
            'onclick' => 'delContent("' . $content->primaryKey . '")'
        ]) ?>
        &nbsp;
    </div>

</div>
