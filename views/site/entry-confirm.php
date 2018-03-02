<?php
use yii\helpers\Html;
?>
<h1 id="item">You have ordered:</h1>
<?php
$length= count($userorder->item_name);
?>
<table class="table">
    <thead>
    <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
<?php
for($i=0; $i<$length;$i++){
//    echo "<pre>";
//    var_dump($userorder->item_name[$i]);
//    var_dump($userorder->item_quantity[$i]);
//    var_dump($userorder->price[$i]);
//    echo "</pre>";
    ?>


        <tr>
            <td><?=$userorder->item_name[$i]?></td>
            <td><?= $userorder->item_quantity[$i]?></td>
            <td><?=$userorder->price[$i]?></td>
        </tr>

<?php

}
?></tbody>
</table>
<h2 id="item">Total:<?=$userorder->total?></h2>
<?php

//echo "<pre>";
//var_dump($userorder);
//echo "</pre>";
//echo "<pre>";
//var_dump($userorder->restaurant);
//echo "</pre>";
//echo "<pre>";
//var_dump($userorder->item_name);
//echo "</pre>";
//echo "<pre>";
//var_dump($userorder->item_quantity);
//echo "</pre>";
//echo "<pre>";
//var_dump($userorder->price);
//echo "</pre>";
?>

<!--<ul>-->
<!--    <li><label>Restaurant</label>: --><?//= Html::encode($order->restaurant) ?><!--</li>-->
<!--    <li><label>Name</label>: --><?//= Html::encode($makeorderform->name) ?><!--</li>-->
<!--    <li><label>Quantity</label>: --><?//= Html::encode($makeorderform->quantity) ?><!--</li>-->
<!--    <li><label>Price</label>: --><?//= Html::encode($makeorderform->price) ?><!--</li>-->
<!--</ul>-->