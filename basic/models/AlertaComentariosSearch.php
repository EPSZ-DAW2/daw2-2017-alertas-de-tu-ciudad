<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlertaComentarios;

/**
 * AlertaComentariosSearch represents the model behind the search form about `app\models\AlertaComentarios`.
 */
class AlertaComentariosSearch extends AlertaComentarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alerta_id', 'crea_usuario_id', 'modi_usuario_id', 'comentario_id', 'cerrado', 'num_denuncias', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['crea_fecha', 'modi_fecha', 'texto', 'fecha_denuncia1', 'bloqueo_fecha', 'bloqueo_notas'], 'safe'],
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
        $query = AlertaComentarios::find();

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
            'crea_usuario_id' => $this->crea_usuario_id,
            'crea_fecha' => $this->crea_fecha,
            'modi_usuario_id' => $this->modi_usuario_id,
            'modi_fecha' => $this->modi_fecha,
            'comentario_id' => $this->comentario_id,
            'cerrado' => $this->cerrado,
            'num_denuncias' => $this->num_denuncias,
            'fecha_denuncia1' => $this->fecha_denuncia1,
            'bloqueado' => $this->bloqueado,
            'bloqueo_usuario_id' => $this->bloqueo_usuario_id,
            'bloqueo_fecha' => $this->bloqueo_fecha,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'bloqueo_notas', $this->bloqueo_notas]);

        return $dataProvider;
    }
}
