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
        <th>Date</th>
        <th>Restaurant</th>
        <th>Total</th>
        <?php if($id_role==1){?>
            <th>User</th>
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
        <tr class="<?=$a?>" id="<?= $historyorder[$a]['id_order'] ?>">
            <td class="history_td"><a class="show_items" id="bla"><i class="glyphicon glyphicon-chevron-down"></i></a></td>
            <td hidden id="id_order"><?= $historyorder[$a]['id_order'] ?></td>
            <td class=""><?= $historyorder[$a]['date_order'] ?></td>
            <td><?= $historyorder[$a]['restaurant'] ?></td>
            <td><?= $historyorder[$a]['total'] ?></td>
            <?php if($id_role==1){?>
                <td><?= $historyorder[$a]['name'].' '.$historyorder[$a]['surname']?></td>
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
   $('.show_items').click(function(){
    var trClass = $(this).closest('tr').attr('class'); 
    var a= $('.'+trClass).find('#id_order').html();
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
          html += '<tr>'+
                        '<td></td>'+
                        '<td>'+data[item].item_name+'</td>'+
                        '<td>'+data[item].item_quantity+'</td>'+
                        '<td>'+data[item].price+'</td>'+
                    '</tr>';
      }
      
      html = '<tr>'+
            '<td colspan="5">'+
                '<table class="table table_item" id="table_item'+a+'" >'+
                   '<thead class="item_head">'+
                    '<tr>'+
                        '<th ><a class="hide_items" id="bla"><i class="glyphicon glyphicon-chevron-up"></i></a></th>'+
                        '<th>Item</th>'+
                        '<th>Quantity</th>'+
                        '<th>Price</th>'+
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
    
   }); 
    });
JS;
$this->registerJs($script_show);
$script_hide=<<<JS
   $(document).ready(function(){
      $('.hide_items').click(function(){  
          console.log('sdvs');
         // var tableId = $(this).closest('table').attr('id'); 
        //  alert(tableId);
         // $('#'+tableId).remove();
        //  var a= $('.'+trClass).find('#id_order').html();
    // $('.table_item'+a).slideUp();  
      });
   });
JS;
$this->registerJs($script_hide);
?>
