<?php

namespace app\models\queries;

use yii\db\ActiveQuery;

class TimeLimitQuery extends ActiveQuery
{
    public function init()
    {
        $limit = $this->getLimitDatetime()->format(\Yii::$app->params['dateTimeFormat']);
        $now = (new \DateTime())->format(\Yii::$app->params['dateTimeFormat']);
        $this->andWhere(['BETWEEN', 'create_time', $limit, $now]);
        parent::init();
    }

    /**
     * @return \DateTime
     */
    protected function getLimitDatetime()
    {
        return new \DateTime('-' . \Yii::$app->params['lifeTime'] . ' hour');
    }
}