<?php

use yii\db\Migration;

/**
 * Class m191122_182001_create
 */
class m191122_182001_create extends Migration
{
    public function up()
    {
        $this->addColumn('words', 'good_answers', $this->string()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('words', 'good_answers');
    }
}
