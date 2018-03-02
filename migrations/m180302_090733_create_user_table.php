<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Handles the creation of table `user`.
 */
class m180302_090733_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id_user' => $this->primaryKey(),
            'name'=>$this->text(),
            'surname'=>$this->text(),
            'username'=>$this->text(),
        'password'=>$this->text(),
        'id_role'=>$this->integer()->defaultValue('0'),
        'auth_key'=>$this->text(),
        'access_token'=>$this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
public function changeColumn(){
        $this->alterColumn('user','id_role','integer NOT NULL 1');
}
}
