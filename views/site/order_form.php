<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\MakeOrderForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
$this->registerJsFile('web/func.js');
$this->title = 'Making order';
$this->params['breadcrumbs'][] = $this->title;
?>


<br class="site-order">
    <h1 id="item"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

<?= $form->field($userorder, 'date_order')->widget(kartik\date\DatePicker::className(), [
    //'language' => 'ru',
    'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
]) ?>
    <?= $form->field($userorder, 'restaurant')->textInput() ?>
    <h1 id="item">Items:</h1>

<div class="form-horizontal" id="item_order">
    <div class="wrapper" id="1">

    <button class="btn  col-md-offset-4 " data-id ="1" name="delete_item" id="delete_item"  title="Delete this item">
        <i class="glyphicon glyphicon-remove"></i>
    </button></br>
    <?= $form->field($userorder, 'item_name[]')->textInput(['multiple'=>'multiple']) ?>
    <?= $form->field($userorder, 'item_quantity[]')->textInput(['type'=>'number', 'multiple'=>'multiple', 'min'=>0, 'placeholder'=>'0']) ?>
    <?= $form->field($userorder, 'price[]')->textInput(['type'=>'number', 'multiple'=>'multiple', 'min'=>0, 'placeholder'=>'0.00', 'step'=>"any"]) ?>
    <hr/>
    </div>
</div>

  <button class="btn btn-success col-md-offset-4 add_item" name="add_item" id="add_item" title="Add one more item">

        <i class="glyphicon glyphicon-plus"></i>

    </button></br>

</br>
<?= $form->field($userorder, 'total')->textInput(['disabled' => 'disabled']) ?>
<div class="form-group" >
        <div class="col-lg-offset-1 col-lg-11" >
            <?= Html::submitButton('I want to make order', ['class' => 'btn btn-primary', 'name' => 'order-button', 'id'=>'make_order']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(document).ready(function(){
    $('#add_item').click(function(e){
         e.preventDefault();
     var x= $('.wrapper').length+1;
     
      let eq = $('.wrapper').eq(0).clone(true); 
      $(eq).attr('id', x);
      var but= $(eq).find("#delete_item");
      $(but).data('data_id', x);
         eq.appendTo('#item_order').find('input').val('') ;
       

      })
      
  
});
JS;
$this->registerJs($script);
?>
<?php
$script_delete = <<< JS
$(document).ready(function(){
    $('#delete_item').click(function(e){
         e.preventDefault();
         event.target.parentNode.remove();
   })
      
  
});
JS;
$this->registerJs($script_delete);
$script_total=<<< JS
$(document).ready(function(){
    // $( "input[name='UserOrder[price][]']" ).mouseout(function (){
    //    var a= $( "input[name='UserOrder[price][]']" ).val();
    //   alert (a); 
    //   });
    //  $( "input[name='UserOrder[price][]']" ).mouseout(function (){
    //  var b= $( "input[name='UserOrder[item_quantity][]']" ).val();
    //  alert(b);
    //  });
    function get_data(data){

    console.log(data.children())
}
get_data($('.item_order'))


});
JS;
$this->registerJs($script_total);

?>

