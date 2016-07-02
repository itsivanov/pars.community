<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\Instagramm;

/**
 * This is the model class for table "sources".
 *
 * @property integer $id
 * @property string $name
 * @property string $site_url
 * @property string $feed_url
 * @property integer $categories
 * @property string $update_status
 * @property string $status
 * @property integer $last_update
 */
class Sources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sources';
    }

		public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

						$feed = $this->site_url;

						$patternYoutube = "#http(s)?://(www.)?youtube.com/user/([^/]*)#";
						preg_match($patternYoutube, $this->site_url, $matchesYoutube);

						if (!empty($matchesYoutube[3])) {
							$feed = 'http://www.youtube.com/feeds/videos.xml?user='.$matchesYoutube[3];
						}

            $this->feed_url = $feed;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'site_url', 'update_status', 'status', 'last_update'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['site_url', 'feed_url'], 'string', 'max' => 1024],
            [['update_status', 'status'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'site_url' => 'Site Url',
            'feed_url' => 'Feed Url',
            'update_status' => 'Update Status',
            'status' => 'Status',
            'last_update' => 'Last Update',
        ];
    }

    /*
    * All sources
    */
    public static function getAll()
    {
        $data = self::find()->orderBy('id DESC')->all();
        return $data;
    }





    /*
    * Select all category for banners
    */
    public static function allCategory()
    {
        $sql = "SELECT * FROM categories ORDER BY category";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    /*
    * Select lalast id for parsing
    */
    public static function selectLastId($last_date)
    {
        return (new \yii\db\Query())
          ->select(['id'])
          ->from('sources')
          ->where(['last_update'=>$last_date])
          ->limit(1)
          ->one();
    }


    /*
    * All from table category_for_banners
    */
    public static function getCategoryForBanners($id)
    {
        $sql = "SELECT * FROM category_for_articles WHERE source_id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }


    /*
    * Add categories for banner
    */
    public static function addCatForSources($categories)
    {
        $banned_id = $categories[0];
        unset($categories[0]);

        self::deleteCategoryes($banned_id);

        if(!empty($categories) && count($categories) > 0)
        {
            foreach ($categories as $key => $value) {
                $sql = "INSERT INTO category_for_articles (category_id, source_id) VALUES ('$value', '$banned_id')";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

    }


    public static function deleteCategoryes($id)
    {
      $sql_del = "DELETE FROM category_for_articles WHERE source_id = '" . $id . "'";
      Yii::$app->db->createCommand($sql_del)->execute();
      return true;
    }


    /*
    * Writing new source in file for parsing
    */
    /*
    public static function writingSourceInFile($array_source)
    {
        $array_merge = null;
        $file = $_SERVER['DOCUMENT_ROOT'] . '/web/parsing.txt';

        // Select old array
        $arr = file_get_contents($file);
        $array_old = json_decode($arr, true);

        if(!empty($array_old))
        {
            foreach($array_old as $item)
            {
                  $array_merge[] = $item;
            }
        }

        // Add new array
        $array_merge[] = $array_source;

        $json = json_encode($array_merge);
        file_put_contents($file, $json);

    }
    */


    /*
    * Delete sources for ids
    */
    public static function deleteForIds($ids)
    {
        foreach($ids as $items)
        {
            $sql_del = "DELETE FROM sources WHERE id = '$items'";
            Yii::$app->db->createCommand($sql_del)->execute();
        }

        return true;

    }


    /*
    *  Change status
    */
    public static function changeStatus($ids, $status, $name)
    {
        foreach($ids as $items)
        {
            $sql_del = "UPDATE sources SET $name = '$status' WHERE id = '$items'";
            Yii::$app->db->createCommand($sql_del)->execute();
        }

        return true;
    }

}
