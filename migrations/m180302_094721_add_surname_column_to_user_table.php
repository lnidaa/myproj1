<?php

use yii\db\Migration;

/**
 * Handles adding surname to table `user`.
 */
class m180302_094721_add_surname_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'surname', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'surname');
    }
}
