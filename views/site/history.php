<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $id_role = Yii::$app->user->identity->id_role; ?>
<?php $id_user = Yii::$app->user->identity->id_user; ?>
<head>
    <?=Html::csrfMetaTags()?>
</head>
<?php if($id_role==1){?>
    <hr/>
    <form id="radio_choose">
    <label class="radio-inline"><input type="radio" name="order" value="1" checked>All orders </label>
    <label class="radio-inline"><input type="radio" name="order" value="2"> My orders</label><br/>
    </form>
    <hr/>
    <form id="search_form" class="form-inline">
        <select id="select_user" class="form-control col-lg-3">
            <option id="all" selected>All users</option>
<?php foreach ($users as $user){?>
    <option id="<?=$user['id_user']?>"><?=$user['surname'].' '.$user['name']?></option>

            <?php }?>
        </select> &nbsp;
        <?= kartik\date\DatePicker::widget(['name' => 'date', 'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ], 'id'=>'date_order']) ?>
        &nbsp;
        <div class="form-group">
           <input type="" class="form-control" id="restaurant" placeholder="Restaurant:">
        </div>
    </form>
    <br/>
<?php }?>
</br>
<table class="table" id="table_order">
    <thead class="order_head">
    <tr>
        <th></th>
        <th></th>
        <th class="col-lg-3">Date</th>
        <th class="col-lg-3">Restaurant</th>
        <th class="col-lg-3">Total</th>
        <?php if($id_role==1){?>
            <th class="col-lg-3">User</th>
        <?php }?>
    </tr>
    </thead>
    <tbody>

    <?php
    $count=count($historyorder);
    for($a=0;  $a<$count; $a++){
        ?>
        <tr class="<?=$a?>" id="<?= $historyorder[$a]['id_order'] ?>" style="background-color:#f7f6f6">
<!--            --><?php //echo "<pre>";
//            var_dump($historyorder[$a]['id_user']);
//            echo "</pre>";?>
            <td ><a href="<?php echo Url::to(['site/edit', 'id' => $historyorder[$a]['id_order']]); ?>" title="Edit order" id="edit_order"><i class="glyphicon glyphicon-pencil"></i></a></td>
           <td class="history_td "><a  class="show_items" title="Show items" id="bla"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
            <td hidden id="id_order" ><?= $historyorder[$a]['id_order'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['date_order'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['restaurant'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['total'] ?></td>
            <?php if($id_role==1){?>
                <td class="col-lg-3"><?= $historyorder[$a]['surname'].' '.$historyorder[$a]['name']?></td>
            <?php }?>
        </tr>
        <?php
    }

//    }

    ?>
    </tbody>
</table>


<?php
$script_show = <<< JS
   $(document).ready(function(){
     $('#table_order').on('click', '.show_items', function(e){

   console.log("scscas");
    console.log (this);
    var trClass = $(this).closest('tr').attr('class');
    var trId = $(this).closest('tr').attr('id');
    var a= $('.'+trClass).find('#id_order').html();
    if($(this).find('i').hasClass('glyphicon-chevron-down')){
         
     $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');

   $.ajax({
   url: 'index.php?r=site/items',
   dataType : "json",
   type:'POST',
   data: {a:a},
   success:function(data){
      console.log(data);
      if (!$("#table_item"+a).length){
      htmlBlock(data,a);
      }
   },
   error: function(){
alert('Error!');
}
   

   })    
    }else{
      $('#table_item' + a).closest('tr').remove();
      $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    }
    
    
   }); 
    });
JS;
$this->registerJs($script_show);
$script_sort = <<< JS
$(document).ready(function(){
     $('#radio_choose').click(function(){
        var choose= $('input[name=order]:checked').val() ;
        $.ajax({
   url: 'index.php?r=site/choose',
   dataType : "json",
   type:'POST',
   data: {choose:choose},
   success:function(data){
       htmlBlockOrders(data);
   }
     });
});
     });
    

JS;
$this->registerJs($script_sort);
$script_function_html=<<<JS
    function htmlBlock(data,a){
        var html = '';
      
      for (var item in data) {
        console.log(item);
          html += '<tr  id="'+a+'" style="background-color:#f8f0ef">'+
                        '<td></td>'+
                        '<td></td>'+
                           '<td></td>'+
                        '<td class="col-lg-3" >'+data[item].item_name+'</td>'+
                        '<td class="col-lg-3">'+data[item].item_quantity+'</td>'+
                        '<td class="col-lg-3">'+data[item].price+'</td>'+
                    '</tr>';
      }
      
      html = '<tr>'+
            '<td colspan="5" class="a">'+
                '<table class="table table_item" id="table_item'+a+'" >'+
                   '<thead class="item_head">'+
                    '<tr >'+
                        '<th ></th>'+
                         '<th></th>'+
                          '<th></th>'+
                        '<th class="col-lg-4" >Item</th>'+
                        '<th class="col-lg-4">Quantity</th>'+
                        '<th class="col-lg-4">Price</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody>' + html + ' </tbody>'+
                '</table>'+
            '</td>'+

        '</tr>';
      
      $('#'+a).after(html);
    }


JS;
$this->registerJS($script_function_html);
$script_function_order=<<<JS
function htmlBlockOrders(data){
    $('#table_order tbody>tr').remove();
     var html = '';
     for (var item in data) {
      html += '<tr class="'+item+'" id="'+data[item].id_order+'" style="background-color:#f7f6f6">'+
                        '<td ><a class="link_edit" title="Edit order"><i class="glyphicon glyphicon-pencil"></i></a></td>'+
                        '<td class="history_td "><a class="show_items" id="bla"><i class="glyphicon glyphicon-chevron-down"></i></a></td>'+
                         '<td hidden id="id_order" >'+data[item].id_order+'</td>'+
                        '<td class="col-lg-3" >'+data[item].date_order+'</td>'+
                        '<td class="col-lg-3">'+data[item].restaurant+'</td>'+
                        '<td class="col-lg-3">'+data[item].total+'</td>'+
                        '<td class="col-lg-3">'+data[item].name+ ' '+data[item].surname+'</td>'+
                    '</tr>';   
     }
    
      $('#table_order tbody').html(html);
}
JS;
$this->registerJS($script_function_order);
$script_search=<<<JS
$(document).ready(function(){
    $('#search_form').change(function(){
          var id_user=$('#select_user option:selected').attr('id');
          var date_order= $('#date_order').val();
          var restaurant= $('#restaurant').val();
        $.ajax({
   url: 'index.php?r=site/search',
   dataType : "json",
   type:'POST',
   data: {id_user:id_user,
       date_order:date_order,
       restaurant:restaurant},
   success:function(data){
     htmlBlockOrders(data);
   }
   });
});
    });
JS;
$this->registerJS($script_search);
$script_edit=<<<JS
$(document).ready(function(){
    $('#table_order').on('click', '.link_edit', function(e){
        var id=$(this).closest('tr').attr('id');
        
      var url = 'index.php?r=site%2Fedit&id='+id+'';
$(location).attr('href',url);
});
    });
JS;
$this->registerJS($script_edit);
?>
