<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Word */
$this->title = 'Add Words';
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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