<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $nummer_block
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $categories;
    public $sources;
    public $file;
    public static $blocks_name = [
        '1' => 'Left',
        '2' => 'Top',
        '3' => 'Right',
        '4' => 'Bottom',
    ];

    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nummer_block'], 'required'],
            [['nummer_block', 'create_date', 'status'], 'integer'],
            [['title'], 'string','max' => 255],
            [['banner', 'due_date', 'title', 'create_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nummer_block' => 'Nummer Block',
            'banners' => 'Banners',
            'create_date' => 'Date',
            'title' => 'Title',
            'due_date' => 'Due date',
            'status' => 'Status',
        ];
    }

    /*
    * All banners
    */
    public static function getAll()
    {
        $data = self::find()->orderBy('id DESC')->all();
        return $data;
    }

    /*
    * Get image
    */
    public static function getOne($id)
    {
        $data = self::find()
                ->where(['id' => $id])
                ->one();
        return $data;
    }

    public function bannersDue() {
      $maxDueTime = time() + (3600 * 24 * 4);
      $count = self::find()
                ->where(['<','due_date', $maxDueTime])
                ->andWhere(['>', 'due_date', 0])
                ->andWhere(['=', 'status', 1])
                ->count();

      return $count;

    }

    public static function getCategories($id)
    {
      $query = (new \yii\db\Query())
                ->select(['b.*', 'c.category as category'])
                ->from('banners b')
                ->leftJoin('category_for_banners cfb', 'b.id = cfb.banner_id')
                ->leftJoin('categories c', 'c.id = cfb.category_id')
                ->where(['b.id' => $id])
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
                ->select(['b.*', 's.name as source'])
                ->from('banners b')
                ->leftJoin('source_for_banners sfb', 'b.id = sfb.banner_id')
                ->leftJoin('sources s', 's.id = sfb.source_id')
                ->where(['b.id' => $id])
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
    * Select all category for banners
    */
    public static function allCategory()
    {
        $sql = "SELECT * FROM categories";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    public static function allSources()
    {
        $sql = "SELECT * FROM sources";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    public static function deleteBannerFromCategories($id)
    {
      $sql_del = "DELETE FROM category_for_banners WHERE banner_id = '" . $id . "'";
      Yii::$app->db->createCommand($sql_del)->execute();
    }


    /*
    * Add categories for banner
    */
    public static function addCatForBanner($categories, $banner_id)
    {
        //$banned_id = $categories[0];

        $categories = explode(',', $categories);

        self::deleteBannerFromCategories($banner_id);

        if(count($categories) > 0)
        {
            foreach ($categories as $cat) {
                $sql = "INSERT INTO category_for_banners (category_id, banner_id) VALUES ('" . $cat . "', '" . $banner_id . "')";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

    }

    public function getByTitle($title) {
      $query = (new \yii\db\Query())
        ->select(['b.title as value', 'b.title as label'])
        ->from('banners b')
        ->where(['LIKE', 'b.title', $title]);

      return $query->all();
    }


    public static function deleteBannerFromSources($id)
    {
        $sql_del = "DELETE FROM source_for_banners WHERE banner_id ='" . $id . "'";
        Yii::$app->db->createCommand($sql_del)->execute();
        return true;
    }

    /*
    * Add sources for banner
    */
    public static function addSrcForBanner($sources,$banner_id)
    {
        $sources = explode(',', $sources);
        self::deleteBannerFromSources($banner_id);

        if(count($sources) > 0)
        {
            foreach ($sources as $src) {
              $sql = "INSERT INTO source_for_banners (source_id, banner_id) VALUES ('" . $src . "', '" . $banner_id . "')";
              Yii::$app->db->createCommand($sql)->execute();
            }
        }

    }

    public static function getAllCategories() {
      return  (new \yii\db\Query())
        ->select(['category as value'])
        ->from('categories')
        ->all();
    }

    public static function getAllSources() {
      return  (new \yii\db\Query())
        ->select(['name as value'])
        ->from('sources')
        ->all();
    }


    /*
    * All from table category_for_banners
    */
    public static function getCategoryForBanners($id)
    {
        $sql = "SELECT * FROM category_for_banners WHERE banner_id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    /*
    * All from table category_for_banners
    */
    public static function getSourcesForBanners($id)
    {
        $sql = "SELECT * FROM source_for_banners WHERE banner_id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        $return = [];
        foreach ($data as $key => $value) {
          $return[] = $value['source_id'];
        }

        return $return;
    }
}
