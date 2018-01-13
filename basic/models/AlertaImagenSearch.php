<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlertaImagen;

/**
 * AlertaImagenSearch represents the model behind the search form about `app\models\AlertaImagen`.
 */
class AlertaImagenSearch extends AlertaImagen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alerta_id', 'orden', 'imagen_revisada', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
            [['imagen_id', 'crea_fecha', 'modi_fecha', 'notas_admin'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AlertaImagen::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'alerta_id' => $this->alerta_id,
            'orden' => $this->orden,
            'imagen_revisada' => $this->imagen_revisada,
            'crea_usuario_id' => $this->crea_usuario_id,
            'crea_fecha' => $this->crea_fecha,
            'modi_usuario_id' => $this->modi_usuario_id,
            'modi_fecha' => $this->modi_fecha,
        ]);

        $query->andFilterWhere(['like', 'imagen_id', $this->imagen_id])
            ->andFilterWhere(['like', 'notas_admin', $this->notas_admin]);

        return $dataProvider;
    }
}
