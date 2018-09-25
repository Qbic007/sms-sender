<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sms`.
 */
class m180925_100243_create_sms_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('sms', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(30),
            'text' => $this->string(160),
            'status' => $this->tinyInteger(),
            'create_time' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'update_time' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->createIndex('i_phone', 'sms', 'phone');
    }

    public function safeDown()
    {
        $this->dropTable('sms');
    }
}
