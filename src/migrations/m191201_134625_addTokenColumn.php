<?php

use yii\db\Migration;

/**
 * Class m191201_134625_addTokenColumn
 */
class m191201_134625_addTokenColumn extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'token', $this->string());
    }

    public function down()
    {
        $this->dropColumn('user', 'token');
    }
}
