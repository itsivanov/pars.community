<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Articles;
use yii\data\SqlDataProvider;

/**
 * ArticlesSearch represents the model behind the search form about `app\modules\admin\models\Articles`.
 */
class ArticlesSearch extends Articles
{
    public $categories;
    public $sources;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_time'], 'integer'],
            [['title', 'description', 'edit_status', 'status', 'content', 'path', 'categories', 'sources', 'vendor_code'], 'safe'],
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
      $this->load($params);
      $params = (!empty($params['ArticlesSearch'])) ? $params['ArticlesSearch'] : [];

      $query = (new \yii\db\Query())
        ->select(['a.*', 'c.category as category', 's.name as sources'])
        ->from('articles a')
        ->leftJoin('article_category ac', 'a.id = ac.article_id')
        ->leftJoin('categories c', 'c.id = ac.category_id')
        ->leftJoin('sources s', 's.id = a.source_id')
        ->groupBy('a.id');


        if(!empty($params['id']))
          $query->andWhere([ '=', 'a.id', $params['id'] ]);

        if(!empty($params['title']))
          $query->andWhere([ 'like', 'a.title', $params['title'] ]);

        if(!empty($params['edit_status']))
          $query->andWhere([ '=', 'a.edit_status', $params['edit_status'] ]);

        if(!empty($params['vendor_code']))
          $query->andWhere([ '=', 'a.vendor_code', $params['vendor_code'] ]);

        if(!empty($params['path']))
          $query->andWhere([ 'like', 'a.path', $params['path'] ]);

        if(!empty($params['create_time']))
          $query->andWhere([ '>=', 'a.create_time', strtotime($params['create_time']) ]);

        if(!empty($params['categories']))
          $query->andWhere([ 'like', 'c.category', $params['categories'] ]);

        if(!empty($params['sources']))
          $query->andWhere([ 'like', 's.name', $params['sources'] ]);

        if(!empty($params['status']))
        {
            if($params['status'] == 2) {
              $query->andWhere([ '=', 'a.status', 0 ]);
            } else {
      				$query->andWhere('a.status = "1" OR a.status="Published"');
            }
        }

        $count = $query->count();


        $dataProvider = new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql(),
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                    'title',
                    'create_time',
                    'path',
                    'status',
                    'edit_status',
                    'vendor_code',
                ],
                'defaultOrder' => ['id'=>SORT_DESC]
            ],
        ]);


        return $dataProvider;
    }
}
