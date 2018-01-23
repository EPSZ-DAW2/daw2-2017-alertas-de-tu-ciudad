<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alerta;

/**
 * AlertaSearch represents the model behind the search form about `app\models\Alerta`.
 */
class AlertaSearch extends Alerta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duracion_estimada', 'area_id', 'imagen_revisada', 'categoria_id', 'activada', 'visible', 'terminada', 'num_denuncias', 'bloqueada', 'bloqueo_usuario_id', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
            [['titulo', 'descripcion', 'fecha_inicio', 'direccion', 'notas_lugar', 'detalles', 'notas', 'url', 'imagen_id', 'fecha_terminacion', 'notas_terminacion', 'fecha_denuncia1', 'bloqueo_fecha', 'bloqueo_notas', 'crea_fecha', 'modi_fecha', 'notas_admin'], 'safe'],
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
        $query = Alerta::find();

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
            'fecha_inicio' => $this->fecha_inicio,
            'duracion_estimada' => $this->duracion_estimada,
            'area_id' => $this->area_id,
            'imagen_revisada' => $this->imagen_revisada,
            'categoria_id' => $this->categoria_id,
            'activada' => $this->activada,
            'visible' => $this->visible,
            'terminada' => $this->terminada,
            'fecha_terminacion' => $this->fecha_terminacion,
            'num_denuncias' => $this->num_denuncias,
            'fecha_denuncia1' => $this->fecha_denuncia1,
            'bloqueada' => $this->bloqueada,
            'bloqueo_usuario_id' => $this->bloqueo_usuario_id,
            'bloqueo_fecha' => $this->bloqueo_fecha,
            'crea_usuario_id' => $this->crea_usuario_id,
            'crea_fecha' => $this->crea_fecha,
            'modi_usuario_id' => $this->modi_usuario_id,
            'modi_fecha' => $this->modi_fecha,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'notas_lugar', $this->notas_lugar])
            ->andFilterWhere(['like', 'detalles', $this->detalles])
            ->andFilterWhere(['like', 'notas', $this->notas])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'imagen_id', $this->imagen_id])
            ->andFilterWhere(['like', 'notas_terminacion', $this->notas_terminacion])
            ->andFilterWhere(['like', 'bloqueo_notas', $this->bloqueo_notas])
            ->andFilterWhere(['like', 'notas_admin', $this->notas_admin]);

        return $dataProvider;
    }
}
