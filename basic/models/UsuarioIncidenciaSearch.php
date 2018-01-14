<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioIncidencia;

/**
 * UsuarioIncidenciaSearch represents the model behind the search form about `app\models\UsuarioIncidencia`.
 */
class UsuarioIncidenciaSearch extends UsuarioIncidencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'destino_usuario_id', 'origen_usuario_id', 'alerta_id', 'comentario_id'], 'integer'],
            [['crea_fecha', 'clase_incidencia_id', 'texto', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptado'], 'safe'],
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
        $query = UsuarioIncidencia::find();

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
            'Fecha de creación' => $this->crea_fecha,
            'destino_usuario_id' => $this->destino_usuario_id,
            'origen_usuario_id' => $this->origen_usuario_id,
            'alerta_id' => $this->alerta_id,
            'comentario_id' => $this->comentario_id,
            'fecha_lectura' => $this->fecha_lectura,
            'fecha_borrado' => $this->fecha_borrado,
            'fecha_aceptado' => $this->fecha_aceptado,
        ]);

        $query->andFilterWhere(['like', 'clase_incidencia_id', $this->clase_incidencia_id])
            ->andFilterWhere(['like', 'texto', $this->texto]);

        return $dataProvider;
    }
}
