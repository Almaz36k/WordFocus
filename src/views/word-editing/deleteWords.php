<?php
use yii\widgets\ActiveForm;
use \yii\helpers\Html;
use \yii\widgets\LinkPager;

?>
<table>
    <tr>
        <th>id</th>
        <th>word</th>
        <th>translate</th>
    </tr>
    <? foreach ($models as $model) {?>
        <? $form = ActiveForm::begin() ?>
        <tr>
            <td><?= $form->field($model, 'id')->hiddenInput(); ?></td>
            <td><?= $form->field($model, 'word')->textInput(); ?></td>
            <td><?= $form->field($model, 'translate')->textInput(); ?></td>
            <td><?= Html::submitButton('delete', ['class' => 'btn btn-primary', 'name' => 'delete-button']) ?></td>
        </tr>

        <? ActiveForm::end(); ?>
    <? } ?>

    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</table>