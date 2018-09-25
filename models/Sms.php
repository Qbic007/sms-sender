<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Sms model
 *
 * @property integer $id
 * @property string $phone
 * @property string $text
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */

class Sms extends ActiveRecord
{
    public static function tableName()
    {
        return 'sms';
    }
}
