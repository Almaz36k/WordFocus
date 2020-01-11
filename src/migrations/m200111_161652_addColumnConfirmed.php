<?php

use yii\db\Migration;

/**
 * Class m200111_161652_addColumnConfirmed
 */
class m200111_161652_addColumnConfirmed extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'confirmed', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('user', 'confirmed');
    }
}
