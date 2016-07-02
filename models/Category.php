<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Page;

class Category extends Model
{

	public static function getOneByName($name)
	{
		return (new \yii\db\Query())
			->select(['*'])
			->from('categories')
			->where(['like', 'category', $name, false])
			->limit(1)
			->one();
	}

	public static function getAll() {

		if (empty(Yii::$app->params['categories'])) {
			Yii::$app->params['categories'] = (new \yii\db\Query())
				->select(['*'])
				->from('categories')
				->indexBy('id')
				->orderBy('parent_id, category_order ASC')
				->all();
		}

		return Yii::$app->params['categories'];

	}

	public static function findIdByName($name) {
		$cat = self::getAll();

		foreach ($cat as $key => $value) {
			if (strtolower($value['category']) == strtolower($name)) return $key;
		}
	}

	public static function getBanners($name){
		$name = str_replace(' ', '%', urldecode($name));
		$categoryID = self::getOneByName($name)['id'];

		if(empty($categoryID))
			return false;


		$banner = (new \yii\db\Query())
						->select(['banners.*'])
						->from('category_for_banners')
						->leftJoin('banners', 'category_for_banners.banner_id=banners.id')
						->where(['category_for_banners.category_id'=>$categoryID])
						->andWhere(['banners.nummer_block'=>'2'])
						->andWhere(['banners.status'=>'1'])
						->all();

		$banner2 = Page::getSourceBanners($categoryID);
		$banner  = array_merge($banner, $banner2);

		if(empty($banner[0]))
			return false;

		return $banner[0];

	}

}
