<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191116_152835_addWordTable
 */
class m191116_152835_addWordTable extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('words',[
            'id' => Schema::TYPE_PK,
            'word' => Schema::TYPE_STRING . ' NOT NULL',
            'translate' => Schema::TYPE_STRING,
        ]);
    }

    public function down()
    {
        $this->dropTable('words');
    }
}