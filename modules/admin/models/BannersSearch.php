<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Banners;
use yii\data\SqlDataProvider;

/**
 * BannersSearch represents the model behind the search form about `app\modules\admin\models\Banners`.
 */
class BannersSearch extends Banners
{
    public $categories;
    public $sources;
    public $blocks_key = [
          'left' => '1',
          'top' => '2',
          'right' => '3',
          'bottom' => '4',
      ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nummer_block', 'title', 'create_date', 'categories', 'sources', 'due_date', 'status'], 'safe'],
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
      $params = (!empty($params['BannersSearch'])) ? $params['BannersSearch'] : [];

      /*
      //set search params
      foreach ($params as $key => $value) {
        var_dump($key);
        var_dump($value);
        if(property_exists($this, $key))
          $this->$key = $value;
      }*/

      $query = (new \yii\db\Query())
        ->select(['b.*', 's.name as source', 'c.category as category'])
        ->from('banners b')
        ->leftJoin('category_for_banners cfb', 'b.id = cfb.banner_id')
        ->leftJoin('categories c', 'c.id = cfb.category_id')
        ->leftJoin('source_for_banners sfb', 'b.id = sfb.banner_id')
        ->leftJoin('sources s', 's.id = sfb.source_id')
        ->groupBy('b.id');

        if(!empty($params['id']))
          $query->andWhere([ '=', 'b.id', $params['id'] ]);

        if(!empty($params['status']))
        {
          if($params['status'] == 2)
            $query->andWhere([ '=', 'b.status', 0]);
          else
            $query->andWhere([ '=', 'b.status', $params['status']]);
        }

        if(!empty($params['title']))
          $query->andWhere([ 'like', 'b.title', $params['title'] ]);

        if(!empty($params['create_date']))
          $query->andWhere([ '>=', 'b.create_date', strtotime($params['create_date']) ]);

        if(!empty($params['due_date']))
          $query->andWhere([ '>=', 'b.due_date', strtotime($params['due_date']) ]);

        if(!empty($params['categories']))
          $query->andWhere([ 'like', 'c.category', $params['categories'] ]);

        if(!empty($params['sources']))
          $query->andWhere([ 'like', 's.name', $params['sources'] ]);

        if(!empty($params['nummer_block']))
          $query->andWhere([ '=', 'b.nummer_block', $params['nummer_block'] ]);


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
                    'create_date',
                    'nummer_block',
                    'due_date',
                    'status',
                ],
                'defaultOrder' => ['id'=>SORT_DESC]
            ],
        ]);


        return $dataProvider;
    }
}
