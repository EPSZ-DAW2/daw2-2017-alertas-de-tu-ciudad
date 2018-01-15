<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Logs]].
 *
 * @see Logs
 */
class LogsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Logs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Logs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
