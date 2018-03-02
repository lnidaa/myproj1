<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to registration:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'surname')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

<?=
$form->field($model, 'id_role')->checkbox([
        'label' => 'I want to do common order',
        'value'=>1,
        'labelOptions' => [
            'style' => 'padding-left:20px;'
        ],
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>"

    ]);
?>
<!--    --><?//= $form->field($model, 'Admin')->checkbox([
//        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
//    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Registration', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
