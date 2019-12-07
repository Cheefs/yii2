<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;

class ActivitySearch extends Activity
{
    public function rules() {
        return [
            [['id', 'started_at', 'finished_at', 'is_main', 'is_repeatable', 'created_at', 'updated_at'], 'integer'],
            [['name', 'desc'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $this->load($params);
        $query = Activity::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ( $this->validate() ) {
            $query->andFilterWhere([
                'id' => $this->id,
                'started_at' => $this->started_at,
                'finished_at' => $this->finished_at,
                'main' => $this->is_main,
                'cycle' => $this->is_repeatable,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ])
            ->andFilterWhere(['like', 'desc', $this->desc ])
            ->andFilterWhere(['like', 'name', $this->name ]);
        }
        return $dataProvider;
    }
}