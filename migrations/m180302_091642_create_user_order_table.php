<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_order`.
 */
class m180302_091642_create_user_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_order', [
            'id_order' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'total' => $this->float(),
            'date_order' => $this->date(),
            'restaurant' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_order');
    }
}
