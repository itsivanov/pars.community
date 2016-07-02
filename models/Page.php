<?php

namespace app\models;

use Yii;

class Page extends \yii\db\ActiveRecord
{

    /*
    *  One article
    */
    // public static function getOne($id)
    // {
    //     $sql = "SELECT * FROM articles WHERE id = '$id'";
    //     $data = Yii::$app->db->createCommand($sql)->queryAll();
		//
    //     return $data;
    // }

    public static function getSettings() {
      $data = (new \yii\db\Query())
            ->select(['*'])
            ->from('settings')
            ->all();

      $settings = [];
      foreach ($data as $value) {
          Yii::$app->params[$value['key']] = $value['value'];
      }

    }

    /*
    * Random related posts
    */
    public static function relatedPosts($id)
    {
        // Выборка всех id постов, кроме основного
        $sql = "SELECT id FROM articles WHERE id <> '$id'";
        $arr = Yii::$app->db->createCommand($sql)->queryAll();

        for($i = 0; $i < 4; $i++)
        {
            // Индексируем массив после удаления из него одного ключа => значения
            $arr = array_values($arr);

            // Выбираем рандомно один пост
            $random = mt_rand(0, count($arr) - 1);
            $id_article = $arr[$random]["id"];

            $sql = "SELECT * FROM articles WHERE id = '$id_article'";
            $related[] =  Yii::$app->db->createCommand($sql)->queryAll();

            // Удалем выбранный пост, чтобы посты не повторялись
            unset($arr[$random]);
        }

        return $related;
    }


    /*
    *  Select categories for one article
    */
    public static function categoryForOneArticle($id)
    {
        $sql = "SELECT c.category
				FROM `article_category` as ac
				LEFT JOIN `categories` as c ON (ac.category_id = c.id)
				WHERE `article_id`='" . $id . "'";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }


    public static function getSourceBanners($catIds)
    {

        $banners =  (new \yii\db\Query())
  						->select(['banners.*'])
  						->from('category_for_articles AS cfa')
              ->leftJoin('source_for_banners AS sfb', 'cfa.source_id=	sfb.source_id')
  						->leftJoin('banners', 'sfb.banner_id=banners.id')
  						->where(['in', 'cfa.category_id', $catIds])
              ->andWhere(['IS NOT', 'banners.id', NULL])
  						->andWhere(['banners.status'=>'1'])
              ->all();

        return $banners;
    }


  	public static function getBanners($categiryes){
      $names = [];
      foreach ($categiryes as $key => $value) {
        $names[] = $value['category'];
      }

      if(empty($names))
        return [];

      $categories = (new \yii\db\Query())->select(['*'])->from('categories')->where(['in', 'category', $names])->all();
      $catIds = [];
      foreach ($categories as $key => $value) {
        $catIds[] = $value['id'];
      }


      if(empty($catIds))
        return [];

  		$banner = (new \yii\db\Query())
  						->select(['banners.*'])
  						->from('category_for_banners')
  						->leftJoin('banners', 'category_for_banners.banner_id=banners.id')
  						->where(['in', 'category_for_banners.category_id', $catIds])
  						->andWhere(['banners.status'=>'1'])
  						->all();

      $banner2 = self::getSourceBanners($catIds);

      $banner = array_merge($banner, $banner2);

  		if(empty($banner[0]))
  			return false;

      $return = [];
      foreach ($banner as $bnr) {
        if(empty($return[$bnr['nummer_block']]))
          $return[$bnr['nummer_block']] = [];

        $return[$bnr['nummer_block']][] = $bnr['banner'];
      }

  		return $return;

  	}
}
