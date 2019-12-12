<?php

use yii\db\Migration;

/**
 * Class m191130_114812_addUser
 */
class m191130_114812_addUser extends Migration
{
    public function up()
    {
        $this->createTable('user',[
            'id' => \yii\db\Schema::TYPE_PK,
            'name' => $this->string()->defaultValue('unnamed'),
            'email' =>  $this->string()->notNull(),
            'password' =>  $this->string()->notNull(),
            'isAdmin' =>  $this->integer()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
