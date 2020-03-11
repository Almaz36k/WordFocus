<?php
use yii\widgets\ActiveForm;
use \yii\helpers\Html;
use \yii\widgets\LinkPager;

/**
 * @var object $models
 * @var int $pages
 */
?>
<table class="table">
    <tr>
        <th>id</th>
        <th>word</th>
        <th>translate</th>
    </tr>
    <? foreach ($models as $model) {?>
        <tr>
            <? $form = ActiveForm::begin(['method' => 'POST']) ?>
            <td><?= $form->field($model, 'id')->textInput()->label(false); ?></td>
            <td><?= $form->field($model, 'word')->textInput()->label(false) ?></td>
            <td><?= $form->field($model['translate'][0], 'translate')->textInput()->label(false) ?></td>
            <td><?= Html::submitButton(
                    'delete',
                    [
                        'class' => 'btn btn-primary',
                        'name' => 'delete-button'
                    ]
                ) ?>
            </td>
        </tr>
        <? ActiveForm::end(); ?>
    <? } ?>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</table>