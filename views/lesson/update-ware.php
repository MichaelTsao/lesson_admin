<?php

use yii\helpers\Html;
use yii\jui\Sortable;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $lesson app\models\Lesson */

$this->title = Yii::t('app', 'Update Ware') . '：' . $lesson->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lessons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $lesson->name, 'url' => ['view', 'id' => $lesson->lesson_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Ware');

\app\assets\JFormAsset::register($this);
?>
<div class="lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="margin: 20px">
        <?php
        $chapters = [];

        foreach ($lesson->children as $chapter) {
            $chapters[] = $this->render('chapter', ['chapter' => $chapter]);
        }

        echo Sortable::widget([
            'items' => $chapters,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'chapter_list',
        ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::button('增加新课', ['class' => 'btn btn-success', 'onclick' => 'newChapter()']) ?>
    </div>

    <div class="form-group">
        <?= Html::a('返回', \yii\helpers\Url::to(['view', 'id' => $lesson->primaryKey]), ['class' => 'btn btn-default']) ?>
        &nbsp;
        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!-- 课件修改页面 -->
<div class="modal fade" id="warePanel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="warePanelTitle">课名</h4>
            </div>
            <div class="modal-body" id="warePanelBody">
                加载中...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="saveWare()">保存</button>
            </div>
        </div>
    </div>
</div>

<script>
    function newChapter() {
        $.get('<?= \yii\helpers\Url::to(['new-chapter'])?>', function (data) {
            $('#chapter_list').append(data);
        });
    }

    function newPoint(id) {
        $.get('<?= \yii\helpers\Url::to(['new-point'])?>?id=' + id, function (data) {
            var list = $('#point_list_' + id);
            list.append(data);
            list.addClass('ui-sortable');
            list.sortable({"cursor": "move"});
        });
    }

    function newSection(id) {
        $.get('<?= \yii\helpers\Url::to(['new-section'])?>?id=' + id, function (data) {
            var list = $('#section_list');
            list.append(data);
            list.addClass('ui-sortable');
            list.sortable({"cursor": "move"});
        });
    }

    function newContent(id, type) {
        $.get('<?= \yii\helpers\Url::to(['new-content'])?>?id=' + id + '&type=' + type, function (data) {
            var list = $('#content_list_' + id);
            list.append(data);
            list.addClass('ui-sortable');
            list.sortable({"cursor": "move"});
        });
    }

    function delChapter(id) {
        $('#panel-' + id).remove();
    }

    function delPoint(id) {
        $('#point-' + id).remove();
    }

    function delSection(id) {
        $('#section-' + id).remove();
    }

    function delContent(id) {
        $('#content-' + id).remove();
    }

    function showWare(id) {
        $('#warePanelTitle').html($('#point-name-' + id).val());
        $.get('<?= \yii\helpers\Url::to(['ware'])?>?id=' + id, function (data) {
            $('#warePanelBody').html(data);
            $('#current-point-id').val(id);
        });
    }

    function saveWare() {
        $("#ware-form").ajaxSubmit({
            success: function (data) {
                alert(data);
            }
        })
    }
</script>