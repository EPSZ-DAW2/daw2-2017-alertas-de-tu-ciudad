<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AlertaImagen]].
 *
 * @see AlertaImagen
 */
class AlertaImagenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AlertaImagen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AlertaImagen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
