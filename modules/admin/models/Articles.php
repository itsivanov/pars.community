<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $statuses = [
            '1' => 'Enabled',
            '2' => 'Disabled',
          ];
    public static $edit_status = [
      '1' => 'Edited',
      '2' => 'Not Edited',
    ];

    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['title', 'description', 'content'], 'required'],
            [['title','video','content'], 'safe'],
            [['keyword','status','description'], 'string','max' => 64],
            [['path'], 'string','max' => 255],
            [['vendor_code'], 'string','max' => 32],
            [['file'], 'file'],
            [['create_time'], 'string'],
            [['read_full_article'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'Vendor code' => 'vendor_code',
            'path' => 'Slug',
            'description' => 'Description',
            'keyword' => 'Keywords',
            'status' => 'Status',
            'content' => 'Content',
            'file' => '',
            'create_time' => 'Create time',
            'video' => 'Video',
            'read_full_article' => 'Read full article',
            'edit_status' => 'Edit Status'
        ];
    }

    /*
    * All articles
    */
    public static function getAll()
    {
        $data = self::find()->orderBy('id DESC')->all();
        return $data;
    }


    public static function changeStatus($ids, $status)
    {
        Yii::$app->db->createCommand()
            ->update('articles', ['status' => $status], "id IN ('" . implode("','", $ids) . "')" )
            ->execute();
    }


    public static function getByIds($ids){
      return self::find()->andWhere(['in', 'id', $ids])->all();
    }

    public static function deleteArticle($id)
    {
      return self::findOne($id)->delete();
    }


    public static function deleteArticleCategory($id)
    {
        $sql_del = "DELETE FROM article_category WHERE article_id = '" . $id . "'";
        Yii::$app->db->createCommand($sql_del)->execute();
        return;
    }

    public static function deleteImage($image)
    {
        if(empty($image))
          return;

        $image_dir = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/";
        if(file_exists($image_dir . $image) && !is_dir($image_dir))
          unlink($image_dir . $image);

        return;
    }


    public function deleteByIds($ids)
    {
      $data = self::getByIds($ids);

      foreach ($data as $key => $value) {
        self::deleteImage($value['image']);
        self::deleteArticleCategory($value['id']);
        self::deleteArticle($value['id']);
      }

    }

		public static function slugify($text)
		{
		  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		  $text = preg_replace('~[^-\w]+~', '', $text);
		  $text = trim($text, '-');
		  $text = preg_replace('~-+~', '-', $text);

		  $text = strtolower($text);

		  if (empty($text))
		    return uniqid();

		  return $text;
		}

		public static function getNextName($title)
		{
			$slug = self::slugify($title);
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
				->select(['title','path'])->from('articles')
				->andWhere(['like', 'path', $name, false])
				->limit(1)->orderBy('path DESC')->one();
		}



    public static function getCategories($id)
    {
      $query = (new \yii\db\Query())
        ->select(['a.*', 'c.category as category'])
        ->from('articles a')
        ->leftJoin('article_category ac', 'a.id = ac.article_id')
        ->leftJoin('categories c', 'c.id = ac.category_id')
        ->where(['a.id' => $id])
        ->groupBy('c.id');


      $data = $query->all();
      $categories = [];
      foreach ($data as $key => $value) {
        $categories[] = $value['category'];
      }

      $categories = implode(', ', $categories);

      if(strlen($categories) > 100)
        $categories = substr($categories, 0, 100) . '...';

      return $categories;
    }

    public static function getSourses($id)
    {

      $query = (new \yii\db\Query())
        ->select(['a.*', 's.name as source'])
        ->from('articles a')
        ->leftJoin('sources s', 's.id = a.source_id')
        ->where(['a.id' => $id])
        ->groupBy('s.id');

      $data = $query->all();
      $sourses = [];
      foreach ($data as $key => $value) {
        $sourses[] = $value['source'];
      }

      $sourses = implode(', ', $sourses);
      if(strlen($sourses) > 100)
        $sourses = substr($sourses, 0, 100) . '...';

      return $sourses;
    }


    /*
    * Selected categoryes
    */
    public static function getSelectedCategories($id)
    {
      $sql = "SELECT * FROM `article_category` WHERE `article_id`='" . $id . "'";
      $data = Yii::$app->db->createCommand($sql)->queryAll();
      $ret = [];
      foreach ($data as $key => $value) {
        $ret[$value['category_id']] = $value['category_id'];
      }
      return $ret;
    }

    /*
    * toggle cathegory
    */
    public static function toggleCathegory($post)
    {
        $sql = "SELECT count(*) as cnt FROM `article_category` WHERE `category_id`='" . $post['cat_id'] . "' AND   `article_id`='" . $post['art_id'] . "'";
        $exsist = Yii::$app->db->createCommand($sql)->queryScalar();

        if($exsist && !$post['checked'])
        {
          $sql = "DELETE FROM `article_category` WHERE `category_id`='" . $post['cat_id'] . "' AND   `article_id`='" . $post['art_id'] . "'";
          $exsist = Yii::$app->db->createCommand($sql)->execute();
        }
        elseif(!$exsist && $post['checked']) {
          $sql = "INSERT INTO `article_category`(`article_id`, `category_id`) VALUES ('" . $post['art_id'] . "','" . $post['cat_id'] . "')";
          $exsist = Yii::$app->db->createCommand($sql)->execute();
        }
    }


    /*
    * Upload images for articles in DB
    */
    public static function setUploadImages($img, $id_article, $val)
    {
        // Create image
        $val = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $val));
        file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/web/uploads/articles/{$img}", $val);

        $sql = "INSERT INTO images_for_articles (name, article_id) VALUES ('$img', '$id_article')";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /*
    * All images for article
    */
    public static function getImagesForArticle($id)
    {
        $sql = "SELECT * FROM images_for_articles WHERE article_id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    /*
    * Select main image
    */
    public static function MainImage($id)
    {
        $sql = "SELECT image FROM articles WHERE id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }



}
