<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<head>
    <?=Html::csrfMetaTags()?>
</head>
<table class="table" id="actual_order">
    <thead class="order_head">
    <tr>
        <th></th>
        <th class="col-lg-2">Restaurant</th>
        <th class="col-lg-2">Item</th>
        <th class="col-lg-2">Quantity</th>
        <th class="col-lg-2">Price</th>
        <th class="col-lg-2">Subtotal</th>
        <th class="col-lg-2">User</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $total=0;
    $count=count($actual_orders);
    for($a=0;  $a<$count; $a++){
    $subtotal=floatval($actual_orders[$a]['price'])*(int)$actual_orders[$a]['item_quantity'];
    $total+=$subtotal;
        ?>
        <tr style="background-color:#f7f6f6">
            <td hidden id="id_item" ><?= $actual_orders[$a]['id_item'] ?></td>
            <td ><a href="<?php echo Url::to(['site/edit', 'id' => $actual_orders[$a]['id_order']]); ?>" title="Edit order" id="edit_order"><i class="glyphicon glyphicon-pencil"></i></a></td>
            <td class="col-lg-2"><?= $actual_orders[$a]['restaurant'] ?></td>
            <td class="col-lg-2"><?= $actual_orders[$a]['item_name'] ?></td>
            <td class="col-lg-2"><?= $actual_orders[$a]['price'] ?></td>
            <td class="col-lg-2"><?= $actual_orders[$a]['item_quantity'] ?></td>
            <td class="col-lg-2"><?= $subtotal?></td>
            <td class="col-lg-2"><?= $actual_orders[$a]['surname'].' '.$actual_orders[$a]['name']?></td>
        </tr>
        <?php
    }

    //    }

    ?>
    </tbody>
</table>
<h2 id="item">Total: <?= $total; ?></h2>