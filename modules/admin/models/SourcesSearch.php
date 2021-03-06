<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Sources;

/**
 * SourcesSearch represents the model behind the search form about `app\modules\admin\models\Sources`.
 */
class SourcesSearch extends Sources
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categories'], 'integer'],
            [['name', 'site_url', 'feed_url', 'update_status', 'status'], 'safe'],
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
        $query = Sources::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'categories' => $this->categories,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'site_url', $this->site_url])
            ->andFilterWhere(['like', 'feed_url', $this->feed_url])
            ->andFilterWhere(['like', 'update_status', $this->update_status])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
