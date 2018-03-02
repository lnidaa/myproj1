<?php

use yii\db\Migration;

/**
 * Handles the creation of table `item_order`.
 */
class m180302_092210_create_item_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item_order', [
            'id_item' => $this->primaryKey(),
            'id_order' => $this->integer(),
            'item_name' => $this->text(),
            'item_quantity' => $this->integer(),
            'price' => $this->float(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item_order');
    }
}
