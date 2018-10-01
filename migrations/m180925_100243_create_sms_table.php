<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sms`.
 */
class m180925_100243_create_sms_table extends Migration
{
    const MAX_PHONE_LENGTH = 30;
    const MAX_SMS_LENGTH = 160;

    public function safeUp()
    {
        $this->createTable('sms', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(self::MAX_PHONE_LENGTH),
            'text' => $this->string(self::MAX_SMS_LENGTH),
            'status' => $this->tinyInteger(),
            'service_id' => $this->integer(),
            'sms_id' => $this->integer(),
            'create_time' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'update_time' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->createIndex('i_create_time', 'sms', 'create_time');
    }

    public function safeDown()
    {
        $this->dropIndex('i_create_time', 'sms');
        $this->dropTable('sms');
    }
}
