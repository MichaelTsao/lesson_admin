<?php

use yii\jui\Sortable;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/20
 * Time: 下午6:41
 *
 * @var $point \app\models\Section Point Model
 */
?>

<?php $form = ActiveForm::begin(['id' => 'ware-form', 'action' => \yii\helpers\Url::to(['set-ware'])]); ?>

<div class="row" style="margin: 10px;">

    <?php
    $sections = [];

    foreach ($point->children as $section) {
        $sections[] = $this->render('section', ['section' => $section]);
    }

    echo Sortable::widget([
        'items' => $sections,
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'clientOptions' => ['cursor' => 'move'],
        'id' => 'section_list',
    ]);
    ?>

    <div class="form-group">
        <?= Html::button('增加段', [
            'class' => 'btn btn-success',
            'onclick' => 'newSection("' . $point->primaryKey . '")'
        ]) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>

