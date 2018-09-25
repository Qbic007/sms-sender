<?php
namespace app\models\forms;

use udokmeci\yii2PhoneValidator\PhoneValidator;
use yii\base\Model;

class SmsSendForm extends Model
{
    public $phone;
    public $text;

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
            'text' => 'Текст сообщения'
        ];
    }

    public function rules()
    {
        return [
            [['phone', 'text'], 'required'],
            ['phone', PhoneValidator::class, 'country'=>'RU']
        ];
    }

    public function clear()
    {
        $this->phone = '';
        $this->text = '';
    }
}
