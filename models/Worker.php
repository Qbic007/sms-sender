<?php

namespace app\models;

use app\interfaces\SmsSenderInterface;
use app\interfaces\WorkerInterface;

class Worker implements WorkerInterface
{
    const SERVICES = [
        SmsSenderService1::class,
        SmsSenderService2::class
    ];

    public function begin()
    {
        while (1) {
            $unsent = $this->getUnsentSms();
            $this->send($unsent);

            $enqueued = $this->getEnqueuedSms();
            $this->check($enqueued);

            $overdue = $this->getOverdueSms();
            $this->overdue($overdue);
        }
    }

    protected function getUnsentSms()
    {
        return Sms::find()
            ->andWhere([
                'status' => Sms::STATUS_UNSENT
            ])
            ->all();
    }

    protected function getEnqueuedSms()
    {
        return Sms::find()
            ->andWhere([
                'status' => Sms::STATUS_ENQUEUED
            ])
            ->all();
    }

    protected function getOverdueSms()
    {
        $limit = (new \DateTime('-' . \Yii::$app->params['lifeTime'] . ' hour'))
            ->format(\Yii::$app->params['dateTimeFormat']);
        return Sms::find()
            ->where(['<', 'create_time', $limit])
            ->andWhere(['NOT IN', 'status', Sms::FINAL_STATUSES])
            ->all();
    }

    /**
     * @param Sms[] $unsentSms
     */
    protected function send(array $unsentSms)
    {
        foreach ($unsentSms as $sms) {
            foreach (self::SERVICES as $service) {
                \Yii::$container->setDefinitions([
                    SmsSenderInterface::class => $service
                ]);
                $sender = \Yii::$container->get(SmsSenderInterface::class);
                if ($smsId = $sender->send($sms)) {
                    $sms->status = Sms::STATUS_SENT;
                    $sms->service_id = $sender->getServiceId();
                    $sms->sms_id = $sender->getSmsId();
                    $sms->save();
                    break;
                }
            }
        }
    }

    /**
     * @param Sms[] $enqueuedSms
     */
    protected function check(array $enqueuedSms)
    {
        foreach ($enqueuedSms as $sms) {
            //todo: checking
        }
    }

    /**
     * @param Sms[] $overdueSms
     */
    protected function overdue(array $overdueSms)
    {
        foreach ($overdueSms as $sms) {
            $sms->status = Sms::STATUS_ERROR;
            $sms->save();
        }
    }
}
