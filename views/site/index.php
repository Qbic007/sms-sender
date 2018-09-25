<?php
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\SmsSendForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="site-sms-send">
    <h1>Отправка sms-сообщения</h1>

    <p>Для отправки сообщения заполните поля ниже:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'sms-send-form']); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'text')->textarea() ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
