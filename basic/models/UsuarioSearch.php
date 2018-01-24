<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area_id', 'confirmado', 'num_accesos', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['email', 'password', 'nick', 'nombre', 'apellidos', 'fecha_nacimiento', 'direccion', 'rol', 'fecha_registro', 'fecha_acceso', 'bloqueo_fecha', 'bloqueo_notas'], 'safe'],
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
        $query = Usuario::find();

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'area_id' => $this->area_id,
            'fecha_registro' => $this->fecha_registro,
            'confirmado' => $this->confirmado,
            'fecha_acceso' => $this->fecha_acceso,
            'num_accesos' => $this->num_accesos,
            'bloqueado' => $this->bloqueado,
            'bloqueo_usuario_id' => $this->bloqueo_usuario_id,
            'bloqueo_fecha' => $this->bloqueo_fecha,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'nick', $this->nick])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'rol', $this->rol])
            ->andFilterWhere(['like', 'bloqueo_notas', $this->bloqueo_notas]);

        return $dataProvider;
    }
}
