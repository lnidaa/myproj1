<?php
use yii\helpers\Html;
?>
<h1 id="item">Information about your order:</h1>
<?php
$length= count($userorder->item_name);
?>
<h3>Restaurant: <?=$userorder->restaurant?> </h3>
<hr>
<h3>Date: <?=$userorder->date_order?></h3>
<hr>
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


?>
