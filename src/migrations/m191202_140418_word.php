<?php

use yii\db\Migration;

/**
 * Class m191202_140418_word
 */
class m191202_140418_word extends Migration
{
    public function up()
    {
        $this->createTable('word',[
            'id' => \yii\db\Schema::TYPE_PK,
            'word' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('word');
    }
}
