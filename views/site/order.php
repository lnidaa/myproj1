<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\MakeOrderForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
$this->title = 'Making order';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-order">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?php
    echo '<label>Check Issue Date</label>';
    echo DatePicker::widget([
        'name' => 'date_order',
        'value' => date('d-M-Y'),
        'options' => ['placeholder' => 'Select issue date ...'],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]
    ]);
    ?>
    <?= $form->field($order, 'restaurant')->textInput() ?>
<div class="form-horizontal" id="item_order">
    <?= $form->field($makeorderform, 'name')->textInput(['type'=>'number']) ?>
    <?= $form->field($makeorderform, 'quantity')->textInput(['type'=>'number']) ?>
    <?= $form->field($makeorderform, 'price')->textInput(['type'=>'number']) ?>
</div>
    <button class="btn btn-success add_item" name="add_item" id="add_item">
        <i class="glyphicon glyphicon-plus"></i>
    </button>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('I want to make order', ['class' => 'btn btn-primary', 'name' => 'order-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php
$script= <<<JS
    $(document).ready(function() {
        alert('jQuery работает');
    });
JS;
$this->registerJS($script, $position);
?>

<script>
    $('#add_item').click(function(event){
      alert("kdshkdshdshkc");
    });
</script>
