<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
print_r($_POST);
?>
<? $form = ActiveForm::begin() ?>
<?= $form->field($model, 'raw_words')->textarea(['rows' => '6'])->label(false) ?>
<?= Html::submitButton(
    'add',
    [
        'type'  => 'submit',
        'class' => 'btn btn-primary',
        'name'  => 'delete-button'
    ]
) ?>
<? ActiveForm::end(); ?>

</td>