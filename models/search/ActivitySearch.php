<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;
/**
 * @property $author string
 **/
class ActivitySearch extends Activity
{
    public $author;
    public $minDate;
    public $maxDate;

    public function rules() {
        return [
            [['id', 'started_at', 'finished_at', 'is_main', 'is_repeatable', 'created_at', 'updated_at'], 'integer'],
            [['name', 'desc', 'author', 'minDate', 'maxDate'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param bool $forCurrentUser признак что ищем только для активного пользователя
     * @return ActiveDataProvider
     */
    public function search( array $params, bool $forCurrentUser ) {
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
                'author_id' => $forCurrentUser ? \Yii::$app->user->id : $this->author_id
            ])
            ->andFilterWhere(['like', 'desc', $this->desc ])
            ->andFilterWhere(['like', 'name', $this->name ]);
        }

        if ( $this->minDate && $this->maxDate ) {
            $query->andWhere([
                'or',
                ['between', 'activity.finished_at', $this->minDate, $this->maxDate],
                ['between', 'activity.started_at', $this->minDate, $this->maxDate]
            ]);
        }


        if ( !$forCurrentUser && $this->author ) {
            $query->joinWith('author as author')
                  ->andWhere(['like', 'author.username', $this->author ]);
        }
        return $dataProvider;
    }
}