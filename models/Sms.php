<?php

namespace app\models;

use app\interfaces\SmsInterface;
use app\models\forms\SmsSendForm;
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

class Sms extends ActiveRecord implements SmsInterface
{
    const STATUS_NEW = 0;
    const STATUS_ENQUEUED = 1;
    const STATUS_SENT = 2;
    const STATUS_ERROR = 3;

    public static function tableName(): string
    {
        return 'sms';
    }

    public function rules(): array
    {
        return [
            [['phone', 'text'], 'safe']
        ];
    }

    public function create(SmsSendForm $smsSendForm)
    {
        $this->setAttributes($smsSendForm->getAttributes());
        $this->setAttribute('status', self::STATUS_NEW);
        $this->save();
    }

    public function getSendingData(): array
    {
        $result = [
            'phone' => $this->phone,
            'text' => $this->text
        ];

        return $result;
    }
}
