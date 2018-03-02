<?php

use yii\db\Migration;

/**
 * Handles dropping surname from table `user`.
 */
class m180302_094551_drop_surname_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'surname');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'surname', $this->integer());
    }
}
