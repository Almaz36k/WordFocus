<?php

use yii\db\Migration;

/**
 * Class m191202_124848_user_words
 */
class m191202_124848_user_words extends Migration
{
    public function up()
    {
        $this->createTable('user_words',[
            'id' => \yii\db\Schema::TYPE_PK,
            'word_id' => $this->integer()->notNull(),
            'translate_id' => $this->integer()->notNull(),
            'user_id' =>  $this->integer()->notNull(),
            'is_owner' =>  $this->integer()->defaultValue(0),
            'good_answers' =>  $this->integer()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('user_words');
    }

}
