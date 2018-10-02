<?php

namespace app\models\queries;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class TimeLimitQuery extends ActiveQuery {
    const TIME_LIMIT = 3600; //seconds

    public function init()
    {
        /**
         * @var ActiveRecord $modelClass
         */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->andWhere(['>=', $tableName.'.status', $this->getLimitDatetime()]);
        parent::init();
    }

    protected function getLimitDatetime()
    {
        return date('Y.m.d H:i:s', time() - self::TIME_LIMIT);
    }
}