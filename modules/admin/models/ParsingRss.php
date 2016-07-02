<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

use app\modules\admin\models\Youtube;
use app\modules\admin\models\Instagramm;
use app\modules\admin\models\Facebook;

use app\modules\admin\models\Articles;

class ParsingRss extends Model
{


    /*
      public static function selectSourcesCategorys()
      {
          $sql = "SELECT * FROM `category_for_articles`";
          $data = Yii::$app->db->createCommand($sql)->queryAll();
          $result = [];
          foreach ($data as $value) {
            if(empty($result[$value['source_id']]))
              $result[$value['source_id']] = [];

            $result[$value['source_id']][] = $value['category_id'];
          }

          return $result;
      }
      */



			public static function parsingById($id)
			{
				$source = (new \yii\db\Query())
					->select(['id', 'site_url', 'feed_url', 'last_update'])
					->from('sources')
					->where(['id' => $id])
					->one();

				$param = self::getParams($source['feed_url'],$source['last_update'], $id);
				$count = self::saveArticles($param, $id);

				self::updateSourceTime($id);

				return $count;
			}

			public static function updateSourceTime($id)
			{
				$sql = "UPDATE `sources` SET `last_update`='" . time() . "' WHERE `id`='" . $id . "'; ";
				Yii::$app->db->createCommand($sql)->execute();
			}

			public static function toBatchInsert($param) {

				$data  = [];
				$slugs = [];

				foreach ($param as $key => $value) {
					if (empty($value['image'])) continue;

					$param[$key]['title'] = self::removeEmoji($value['title']);
					$param[$key]['path']  = Articles::getNextName($value['title']);
					if (!in_array($param[$key]['path'], $slugs))
						$slugs[] = $param[$key]['path'];
					else
						$param[$key]['path'] .= '_' . uniqid();
				}

				foreach ($param as $key => $value) {

					if (empty($value['image'])) continue;

					$data[] = [
						$value['path'],
						$value['title'],
						$value['content'],
						$value['image'],
						(empty($value['video'])) ? '' : $value['video'],
						$value['source_time'],
						(empty($value['read_full_article'])) ? '' : $value['read_full_article'],
						(empty($value['hover_color'])) ? '' : $value['hover_color'],
						(empty($value['status'])) ? 1 : $value['status'],
            //0,
            $value['vendor_code'],
            $value['source_id'],
						$value['create_time']
					];
				}
				return $data;
			}

			public static function saveArticles($param, $sourceId)
			{
				if (empty($param)) return false;

					$last_id = Yii::$app->db->createCommand("SELECT * FROM `articles` ORDER BY `id` DESC LIMIT 0,1 ")->queryScalar();

					Yii::$app->db->createCommand()->batchInsert('articles', [
						'path',
						'title',
						'content',
						'image',
						'video',
						'source_time',
						'read_full_article',
						'hover_color',
						'status',
            'vendor_code',
						'source_id',
						'create_time'], $param)->execute();

					self::assignArticlesCategory($last_id);

					return count($param);
			}



			public static function getParams($feed, $lastUpdate, $sourceId)
			{
				if (strpos($feed, 'facebook')) {
					$param = Facebook::getFeed($feed, $lastUpdate); // https://www.youtube.com/user/RHCPtv
					foreach ($param as $key => $value) {
            $param[$key]['status'] = 1;
            $param[$key]['vendor_code'] = md5($param[$key]['title']);
						$param[$key]['source_id']   = $sourceId;
						$param[$key]['create_time'] = time();
					}

					$param = self::toBatchInsert($param);
				} elseif(strpos($feed, 'youtube')) {
					$param = Youtube::setYoutube($feed, $lastUpdate); // https://www.youtube.com/user/RHCPtv

					for ($i=0; $i < count($param); $i++) {
            $param[$i]['status'] = 1;
            $param[$i]['vendor_code'] = md5($param[$i]['title']);
						$param[$i]['source_id']   = $sourceId;
						$param[$i]['create_time'] = time();
					}

					$param = self::toBatchInsert($param);

				} elseif (strpos($feed ,'instagram')) {
					$param = Instagramm::directlyFromInstagram($feed, $lastUpdate);

					for ($i=0; $i < count($param); $i++) {
            $param[$i]['status'] = 1;
            $param[$i]['vendor_code'] = md5($param[$i]['title']);
						$param[$i]['source_id']   = $sourceId;
						$param[$i]['create_time'] = time();
					}

					$param = self::toBatchInsert($param);

				} else {
					$param = [];
				}


				// elseif(strpos($feed ,'iconosquare')) // instagram
				// {
				//     $param = self::setInstagramm($feed, $last_update); // https://www.instagram.com/wevolverapp/
				// }
				// elseif(strpos($feed ,'gplus'))
				// {
				//     https://plus.google.com/+ASOS/posts?hl=en
				//     http://gplus-to-rss.appspot.com/rss/+ASOS
				//     $param = self::setGoogleplus($feed, $last_update);
				// }
				// elseif(strpos($feed ,'wallflux'))
				// {
				//     Сгенерировать id по ссылке группы - https://www.facebook.com/groups/bizbloggingbuzz/
				//     на сайте https://lookup-id.com/
				//
				//     http://www.wallflux.com/feed/371411309668671
				//
				//     $param = self::setFacebook($feed, $last_update);
				// }

				return $param;
			}

      /*
      * Parsing and insert posts and links in db
      */
      public static function parsing()
      {

          // Select all link for parsing
          $sql = "SELECT id, site_url, feed_url, last_update FROM sources WHERE (status = 'Active' OR status = '1')
					ORDER BY last_update ASC LIMIT 10 ";
          $data = Yii::$app->db->createCommand($sql)->queryAll();

          // Start parsing
          foreach($data as $item)
          {
							self::updateSourceTime($item['id']);

              $feed = $item['feed_url'];
              $site = $item['site_url'];

              $last_update = $item['last_update'];
              $param = false;

							$param = self::getParams($feed, $last_update, $item['id']);
							if (!empty($param))
								self::saveArticles($param, $item['id']);

          }

          return true;

      }

      public static function assignArticlesCategory($last_id)
      {
          $sql = "SELECT count(*) as cnt FROM articles a
                    LEFT JOIN category_for_articles cfa ON cfa.source_id = a.source_id WHERE a.id>'" . $last_id . "'";
          $count = Yii::$app->db->createCommand($sql)->queryScalar();

          for($i = 0; $i < $count; $i = $i + 200)
          {
            $sql = "SELECT a.id, cfa.category_id FROM articles a
                      LEFT JOIN category_for_articles cfa ON cfa.source_id = a.source_id WHERE a.id>'" . $last_id . "' LIMIT " . $i . ", 200;";
            $data = Yii::$app->db->createCommand($sql)->queryAll();

						foreach ($data as $key => $value) {
							if (empty($value['category_id'])) unset($data[$key]);
						}

						if (!empty($data))
            	Yii::$app->db->createCommand()->batchInsert('article_category', ['article_id', 'category_id'], $data)->execute();
          }
      }

      /*
      * Parse XML in array
      */
      public static function getXml($url_xml)
      {
          $url_xml = (string)$url_xml;

					$xml_source = str_replace(array("&amp;", "&"), array("&", "&amp;"), $url_xml);
					$xml  = @simplexml_load_string($xml_source);

					if(empty($xml))
						return [];

          $json = json_encode($xml);
          $array_channel = json_decode($json,true);

          return $array_channel;
      }


      /*
      * Random name for images
      */
      public static function setRandom($ext = 'jpg')
      {
          $rand1 = time() . mt_rand(1, 100);
          //$rand2 = mt_rand(1, 100);

          $new_name_image = "image" . $rand1 . '.' . $ext;

          if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $new_name_image))
          {
              self::setRandom();
          }
          else
          {
              return $new_name_image;
          }
      }

			public static function uniqidName($ext = 'jpg')
			{

					$name = uniqid('img_') . '.' . $ext;

					if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $name)) {
						self::uniqidName($ext);
					} else {
						return $name;
					}
			}

      /*
      * remove trash from title
      */
      public static function removeEmoji($text){
        return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
      }


      /*
      * Generate Right Date
      */
      public static function generateRightDate($d)
      {
        date_default_timezone_set('Europe/London');
        $date = strtotime($d);
        //$right = date('d F Y', $date);

        return $date;
      }



      public static function getExt($url)
      {
          $data = explode('?', $url)[0];
          if(strpos($data, '.jpg') || strpos($data, '.jpeg'))
            return 'jpg';
          elseif( strpos($data, '.png') )
            return 'png';
          elseif( strpos($data, '.gif') )
            return 'gif';
          else
            return 'jpg';
      }

      /*
      * Upload image to server
      */
      public static function imageSaver($url_image)
      {
          $add_img = false;
          $current = @file_get_contents($url_image);


          if($current)
          {
            $ext = self::getExt($url_image);
            $image = self::setRandom($ext);
            $file = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $image;
            $add_img = @file_put_contents($file, $current);
          }

          if($add_img)
              return $image;
          else
             return false;

      }


      /*
      * Add main color for image
      */
      public static function addColorForImage($image)
      {

          $patch_image = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $image;

          $color_image = self::generateColor($patch_image);

          if($color_image)
          {
              return $color_image;
          }
          else
          {
              return false;
          }

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

}
