<?php

use yii\db\Migration;

/**
 * Class m191202_140339_translate
 */
class m191202_140339_translate extends Migration
{
    public function up()
    {
        $this->createTable('translate',[
            'id' => \yii\db\Schema::TYPE_PK,
            'word_id' => $this->integer()->notNull(),
            'translate' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('translate');
    }

}
