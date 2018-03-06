<?php

use yii\helpers\Html;

?>
<?php $id_role = Yii::$app->user->identity->id_role; ?>
<head>
    <?=Html::csrfMetaTags()?>
</head>
<table class="table" id="table_order">
    <thead class="order_head">
    <tr>
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
//    echo "<pre>";
//    var_dump($items);
//    echo "</pre>";
    $count=count($historyorder);
    // foreach ($historyorder as $order) {
    for($a=0;  $a<$count; $a++){
        ?>
        <tr class="<?=$a?>" id="<?= $historyorder[$a]['id_order'] ?>" style="background-color:#f7f6f6">
            <td class="history_td "><a class="show_items" id="bla"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
            <td hidden id="id_order" ><?= $historyorder[$a]['id_order'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['date_order'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['restaurant'] ?></td>
            <td class="col-lg-3"><?= $historyorder[$a]['total'] ?></td>
            <?php if($id_role==1){?>
                <td class="col-lg-3"><?= $historyorder[$a]['name'].' '.$historyorder[$a]['surname']?></td>
            <?php }?>
        </tr>
        <?php
    }

//    }

    ?>
    </tbody>
</table>


<?php
//echo "<pre>";
//var_dump($items);
//echo "</pre>";
$script_show = <<< JS
    $(document).ready(function(){
   $('.show_items').click(function(e){
    var trClass = $(this).closest('tr').attr('class'); 
    var a= $('.'+trClass).find('#id_order').html();
    if($(this).find('i').hasClass('glyphicon-chevron-down')){
        $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    // alert(a);
   // $('.table_item'+a).slideDown();
   $.ajax({
   url: 'index.php?r=site/items',
   dataType : "json",
   type:'POST',
   data: {a:a},
   success:function(data){
      console.log(data);
      if (!$("#table_item"+a).length){
      var html = '';
      
      for (var item in data) {
        console.log(item);
          html += '<tr class="a" style="background-color:#f8f0ef">'+
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
                        '<th class="col-lg-3" >Item</th>'+
                        '<th class="col-lg-3">Quantity</th>'+
                        '<th class="col-lg-3">Price</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody>' + html + ' </tbody>'+
                '</table>'+
            '</td>'+

        '</tr>';
      
      $('#'+a).after(html);
      }
     // alert(data);
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
$script_hide=<<<JS
   // $(document).ready(function(){
   //    $('.show_items').on('click', function(e){
   //      
   //       // var tableId = $(this).closest('table').attr('id'); 
   //       // // alert(tableId);
   //       // $('#'+tableId).remove();
   //       // var a= $('.'+trClass).find('#id_order').html();
   //  $('.table_item'+a).slideUp();  
   //    });
   // });
JS;
//$this->registerJs($script_hide);
?>
