<?php

namespace app\modules\admin\models;

use Yii;
use \yii\db\Query;
use app\modules\admin\models\Articles;
use yii\data\ArrayDataProvider;
/**
 * This is the model class for table "links".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_id
 */
class Pages extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'static_pages';
    }

    public function rules()
    {
        return [
            [['data', 'title'], 'required'],
            [['update_date', 'id', 'orders'], 'integer'],
            [['title', 'path', 'meta_keyword', 'meta_description'], 'string', 'max' => 255],
            [['data'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'update_date' => 'Update Date',
            'title' => 'Title',
            'data' => 'Data',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'orders' => 'Order',
            'path' => 'Slug',
        ];
    }

    public static function findAllPages()
    {
      $data = (new Query())->select(['*'])->from(self::tableName())->all();
      $provider = new ArrayDataProvider([
          'allModels' => $data,
          'pagination' => [
              'pageSize' => 10,
          ],
          'sort' => [
              'attributes'   => ['orders', 'id', 'title', 'path', 'data', 'update_date', 'meta_keyword', 'meta_description'],
              'defaultOrder' => ['orders' => SORT_ASC],
          ],
      ]);
      return $provider;
    }

    public static function checkSlug($title)
    {
      $slug = Articles::slugify($title);
			$slug = substr($slug, 0, 200);

			$data = self::checkName($slug);
			if (empty($data)) return $slug;

			for ($i=2; $i < 9; $i++) {
				$slugNew = $slug . '_' . $i;
				$data = self::checkName($slugNew);
				if (empty($data)) return $slugNew;
			}

			return $slug . '_' . uniqid();
		}

		public static function checkName($name) {
			return (new \yii\db\Query())
				->select(['title','path'])->from('static_pages')
				->andWhere(['like', 'path', $name, false])
				->limit(1)->orderBy('path DESC')->one();
		}

    public static function setOrder($data)
    {
      for($i=0; $i<count($data); $i++)
      {

          Yii::$app->db->createCommand()->update('static_pages', ['orders' => $i], 'id = ' . $data[$i])->execute();
      }
    }
}
