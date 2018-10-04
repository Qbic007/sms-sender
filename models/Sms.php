<?php

namespace app\models;

use app\models\forms\SmsSendForm;
use app\models\queries\TimeLimitQuery;
use yii\db\ActiveRecord;

/**
 * Sms model
 *
 * @property integer $id
 * @property string $phone
 * @property string $text
 * @property integer $status
 * @property integer $service_id
 * @property string $sms_id
 * @property string $created_at
 * @property string $updated_at
 */
class Sms extends ActiveRecord
{
    const STATUS_UNSENT = 0;
    const STATUS_ENQUEUED = 1;
    const STATUS_SENT = 2;
    const STATUS_ERROR = 3;

    const FINAL_STATUSES = [
        self::STATUS_SENT,
        self::STATUS_ERROR
    ];

    public static function tableName(): string
    {
        return 'sms';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'phone',
                    'text',
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ]
        ];
    }

    public static function find()
    {
        return new TimeLimitQuery(static::class);
    }

    public function create(SmsSendForm $smsSendForm)
    {
        $this->setAttributes($smsSendForm->getAttributes());
        $this->setAttribute('status', self::STATUS_UNSENT);
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

    public function getId(): int
    {
        return $this->id;
    }
}
