<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

class Articles extends \yii\db\ActiveRecord
{

		const ITEM_ON_FIRST_PAGE    = 15;
		const ITEM_ON_CATEGORY_PAGE = 9;
		const ITEM_ON_PAGE          = 9;

    /*
    *  All articles
    */
    public static function getAll($params = [])
    {
				$data = self::get(array_merge([
					'offset'   => 0,
					'limit'    => self::ITEM_ON_FIRST_PAGE,
				], $params));

				// Add main color for image
				$data['data']  = self::addColorForImage($data['data']);
				$data['pages'] = ($data['count'] - self::ITEM_ON_FIRST_PAGE ) / self::ITEM_ON_PAGE + 1;

				return $data;
    }

		public static function getRss($category)
		{
			$param = ['limit' => 100, 'offset' => 0];

			if($category)
				$param['category'] = urldecode($category);

			$data = self::get($param)['data'];

			$title = ($category) ? Yii::$app->name . ' ' . $category  					 												: Yii::$app->name;
			$link  = ($category) ? Url::base(true) . '/category/' . str_replace(' ', '+', $category)    : Url::base(true);

			$rssHead = '<?xml version="1.0" encoding="UTF-8" ?>
							<rss version="2.0">

							<channel>
								<title>' . $title . '</title>
								<link>' . $link . '</link>
								<description>' . $title . '</description>';

			$rssItems = '';

			foreach ($data as $key => $value)
			{
					$rssItems .= self::getRssItem($value);
			}


			$rssFooter = "</channel></rss>";

			return $rssHead . $rssItems . $rssFooter;

		}

		public static function getRssItem($value)
		{
			$url = Url::base(true) . '/article/' . $value['path'];
			$title = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $value['title']);
			$imageUrl = Url::base(true) . '/uploads/articles/' . $value['image'];
			$pathImage  = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $value['image'];

			$w = $h = '150';
			if(file_exists($pathImage))
			{
				$size = getimagesize($pathImage);
				$w =  $size[0];
				$h = $size[1];
			}

			$item = "<item>
							<title>" . $title . "</title>
							<link>" . $url . "</link>
							<description>" . htmlspecialchars($value['description']) . "</description>
							<image>
								<title>" . $title . "</title>
								<url>" . $imageUrl . "</url>
								<link>" . $url . "</link>
							</image>
							<content>" . htmlspecialchars(trim($value['content'])) . "</content>
							<keyword>" . htmlspecialchars($value['keyword']) . "</keyword>
							<created>" . date('Y-m-d H:i:s', $value['create_time']) . "</created>
							<video>" . preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $value['video']) . "</video>
							</item>";

			return $item;
		}

    /*
    * Add main color for image
    */
    public static function addColorForImage($data)
    {

        for ($i = 0; $i < count($data); $i++) {

            if (!empty($data[$i]['image']) && empty($data[$i]['hover_color'])) {


              if(strpos($data[$i]['image'], 'http') !== false) {
								$patch_image = $data[$i]['image'];
							} else {
								$patch_image = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $data[$i]['image'];
							}

							if (!is_file($patch_image)) continue;

              $color_image = self::generateColor($patch_image);

              if ($color_image) {
                  $data[$i]['hover_color'] = $color_image;
              }

							// Yii::$app->db->createCommand()
							// ->update('articles', ['hover_color' => $color_image], 'id = '.$data[$i]['id'])->execute();
            }
        }

        return $data;
    }


    /*
    *  Generate main color for images
    */
    public static function generateColor($image)
    {

        if(@$im = imagecreatefromjpeg($image))
        {
            // Open image
            //$im = imagecreatefromjpeg($image);
        }
        elseif(@$im = imagecreatefrompng($image))
        {
            // Open image
            //$im = imagecreatefrompng($image);
        }
        else
        {
            return false;
        }

        // Generate color
        $start_x = 40;
        $start_y = 50;
        $color_index = imagecolorat($im, $start_x, $start_y);
        $color_tran = imagecolorsforindex($im, $color_index);

        // Диапазон чисел, отвечающих за светлые цвета
        $range_of_numbers = range(235, 255);

        // Если светлый цвет, то заменяем его на серый (rgba(95, 87, 87, 0.9))
        if(in_array($color_tran['red'], $range_of_numbers) ||
           in_array($color_tran['green'], $range_of_numbers) ||
           in_array($color_tran['blue'], $range_of_numbers))
        {
            $rgba = 'rgba(95, 87, 87, 0.9)';
        }
        else
        {
            $rgba = 'rgba(' . $color_tran['red'] . ', ' . $color_tran['green'] . ', '
            . $color_tran['blue'] . ', ' . 0.9 .')';
        }

        return $rgba;

    }

    /*
    * Link more (articles)
    */
    public static function LinkMore($page, $params)
    {

			if (empty($params['category']) && empty($params['search'])) {
				$firstPageCount = self::ITEM_ON_FIRST_PAGE;
			} else {
				$firstPageCount = self::ITEM_ON_CATEGORY_PAGE;
			}

			$countItem = $firstPageCount + self::ITEM_ON_PAGE * ($page - 2);

			$get = [
				'offset'   => $countItem,
				'limit'    => self::ITEM_ON_PAGE,
			];

			if (!empty($params['category'])) $get['category'] = $params['category'];
			if (!empty($params['search'])) $get['search'] = $params['search'];

			$data = self::get($get);

			$data['data']  = self::addColorForImage($data['data']);
			$data['pages'] = self::getPages($data['count'],$firstPageCount);

      return $data;
    }




    /*
    * Select main categories for frontend
    */
    public static function getMainCategories()
    {
				$sql = "SELECT c.id, c.category, c.category_order, COUNT(ac.article_id) AS articles
				FROM categories AS c
				LEFT JOIN article_category AS ac ON ac.category_id = c.id
				WHERE c.parent_id=0
				GROUP BY c.id
				ORDER BY `c`.`category_order` ASC";

				$data = Yii::$app->db->createCommand($sql)->queryAll();
				return $data;
    }


    /*
    * Select parents categories for frontend
    */
    public static function getPanrentCategories($parent_id)
    {
        $sql = "SELECT * FROM categories WHERE parent_id = '$parent_id' ORDER BY category_order ASC";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


		public static function getPages($count, $firstPage = self::ITEM_ON_PAGE) {
			return round( (($count - $firstPage) / self::ITEM_ON_PAGE + 1), 0, PHP_ROUND_HALF_UP );
		}


    /*
    *  Select all sources (articles) from one category
    */
    public static function getSourcesOneCategory($name)
    {
			$data = self::get([
				'limit'    => self::ITEM_ON_CATEGORY_PAGE,
				'category' => $name,
			]);


			// Add main color for image
			$data['data']  = self::addColorForImage($data['data']);

			$data['pages'] = self::getPages($data['count'],self::ITEM_ON_CATEGORY_PAGE);

			return $data;
    }

		public static function findFirst($search)
		{
			$data = self::get([
				'limit'    => self::ITEM_ON_CATEGORY_PAGE,
				'offset'   => 0,
				'search'   => $search,
			]);

			$data['data']  = self::addColorForImage($data['data']);
			$data['pages'] = self::getPages($data['count'],self::ITEM_ON_CATEGORY_PAGE);

			return $data;
		}



		public static function getOneByPath($path)
		{
			return (new \yii\db\Query())
				->select(['*'])
				->from('articles')
				->where(['path'=>$path])
				->limit(1)
				->one();
		}

		public static function getOne($id)
		{
			return (new \yii\db\Query())
				->select(['*'])
				->from('articles')
				->where(['id'=>$id])
				->limit(1)
				->one();
		}

		public static function getLinksToOne($id)
		{
			return (new \yii\db\Query())
				->select(['*'])
				->from('links')
				->where(['article_id'=>$id])
				->all();
		}

		public static function getRandom($id, $count = 4) {

					$idList = $id;

					$related = [];

	        for ($i = 0; $i < $count; $i++) {

						$sql =
							"SELECT *
							FROM articles AS r1
							JOIN (
								SELECT (RAND() * (
									SELECT MAX(id) FROM articles
								)) AS idrand
							) AS r2
							WHERE r1.id >= r2.idrand AND r1.id NOT IN ({$idList})
							ORDER BY r1.id ASC LIMIT 1;";

							$arr = Yii::$app->db->createCommand($sql)->queryOne();
							$related[] = $arr;
							$idList .= ','.$arr['id'];
	        }

	        return $related;

		}


		public static function get($param) {

			if (!empty($param['search'])) {

				$search         = new Search();
				$search->table  = 'articles';
				$search->limit  = $param['limit'];
				$search->offset = $param['offset'];
				$search->fields = [
					'title'   => 60,
					'content' => 20,
				];

				return $search->search($param['search']);

			}

			$categoryes = [];
			if (!empty($param['category'])) {

				//$categoryId = Category::findIdByName($param['category']);

				$category = Category::getOneByName($param['category']);
				if(!empty($category['id']))
					$categoryes[] = $category['id'];

				if($category['parent_id'] == 0)
				{
					$findChildren = self::getPanrentCategories($category['id']);
					foreach ($findChildren as $key => $value) {
						$categoryes[] = $value['id'];
					}
				}

			}

			$query = (new \yii\db\Query())
				->select(['*'])
				->from('articles')
				->where('(status = "1" OR status="Published") AND `image` != ""')
				->orderBy('id DESC');

				if (!empty($param['offset'])) {
					$query->offset($param['offset']);
				}

				if (!empty($param['limit'])) {
					$query->limit($param['limit']);
				}

				if (count($categoryes) > 0) {

					$query->rightJoin('article_category','article_category.article_id = articles.id');
					$query->andWhere(['IN', 'article_category.category_id', $categoryes]);

				}


				$count = $query->count();
				$data  = $query->all();

				// Add main color for image
				//$data = self::addColorForImage($data);

				return ['data' => $data, 'count' => $count];
		}

}
