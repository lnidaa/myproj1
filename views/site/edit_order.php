<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\MakeOrderForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
$this->registerJsFile('web/func.js');
$this->title = 'Editing order';
$this->params['breadcrumbs'][] = $this->title;
?>


<br class="site-order">
<h1 id="item"><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'edit-order-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]); ?>
<?= $form->field($userorder, 'id_order')->textInput()->hiddenInput(['value'=>$order_information[0]['id_order']])->label(false)?>
<?= $form->field($userorder, 'date_order')->widget(kartik\date\DatePicker::className(), [
    //'clientOptions' => ['defaultDate' =>$order_information[0]['date_order'] ],
   // 'attribute'=>$order_information[0]['date_order'],
//    'htmlOptions' => array(
//        'value' => $order_information[0]['date_order'], // set the default date here
//    ),
    'options' => [ 'value' => $order_information[0]['date_order']],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true
    ]
]) ?>

<?= $form->field($userorder, 'restaurant')->textInput(['value'=>$order_information[0]['restaurant']]) ?>
<h1 id="item">Items:</h1>
<?php foreach($order_information as $ord){?>
    <div class="form-horizontal" id="item_order">
        <div class="wrapper" id="<?=$ord['id_item']?>">

            <a class="btn  col-md-offset-4 " data-id ="1" name="delete_item" id="delete_item"  title="Delete this item">
                <i class="glyphicon glyphicon-remove"></i>
            </a></br>
            <?= $form->field($userorder, 'id_item[]')->textInput()->hiddenInput(['multiple'=>'multiple','value'=>$ord['id_item']])->label(false)?>
            <?= $form->field($userorder, 'item_name[]')->textInput(['multiple'=>'multiple','value' => $ord['item_name']] ) ?>
            <?= $form->field($userorder, 'item_quantity[]')->textInput(['type'=>'number', 'multiple'=>'multiple', 'min'=>0, 'placeholder'=>'0', 'value' => $ord['item_quantity']]) ?>
            <?= $form->field($userorder, 'price[]')->textInput(['type'=>'number', 'multiple'=>'multiple', 'min'=>0, 'placeholder'=>'0.00', 'step'=>"any", 'value' => $ord['price']]) ?>
            <hr/>
        </div>
    </div>
<?php } ?>

<a class="btn  col-md-offset-4 add_item" name="add_item" id="add_item" title="Add one more item">

    <i class="glyphicon glyphicon-plus"></i>

</a></br>

</br>
<?= $form->field($userorder, 'total')->textInput(['value'=>$order_information[0]['total']]) ?>
<div class="form-group" >
    <div class="col-lg-offset-1 col-lg-11" >
        <?= Html::submitButton('Edit order', ['class' => 'btn btn-primary', 'name' => 'order-button', 'id'=>'make_order']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(document).ready(function(){
    get_total();
    $('#add_item').click(function(e){
         e.preventDefault();
         
     var x= $('.wrapper').length+1;
     
      let eq = $('.wrapper').eq(0).clone(true); 
      $(eq).attr('id', x);
      var but= $(eq).find("#delete_item");
      $(but).data('data_id', x);
         eq.appendTo('#item_order').find('input').val('') ;
      get_total();
// getData();
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
           var wrappers=$('#item_order').find('.wrapper');
        if(wrappers.length>1)
         var divId=$(this).closest('div').attr('id');
        $('div #'+divId).remove();
        get_total();    
         
       
        // event.target.parentNode.remove();
   })
      
  
});
JS;
$this->registerJs($script_delete);

$script_total=<<< JS
function get_total(){
  var wrappers=$('#item_order').find('.wrapper');
  var total=0;
  for(var i = 0; i < wrappers.length; i++ ){
      var a=$(wrappers[i]).find('#userorder-item_quantity').val();
      var b=$(wrappers[i]).find('#userorder-price').val();
      var subtotal=a*b;
      total=total+subtotal;
      total.toFixed(2);
 };
   $.ajax({
   url: 'index.php?r=site/total',
   dataType : "html",
   type:'POST',
   data: {total:total},
   success:function(res){
       $('#userorder-total').val(res);
      }
    });
}

JS;
$this->registerJs($script_total);
$script_changing=<<< JS
$(document).ready(function(){
   $('input').change(function(){
       get_total();
   })
});


JS;
$this->registerJs($script_changing);
?>
