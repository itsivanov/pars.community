<?php

namespace app\models;

use Yii;

class StaticPages extends \yii\db\ActiveRecord
{

    /*
    *  All articles
    */
    public static function getAll() {
				return self::get()->all();
    }

		public static function getOne($slug) {
        return self::get(['slug' => $slug])->one();
		}


    public static function get($param = []){
      $query = (new \yii\db\Query())->select(['*'])->from('static_pages')->orderBy('orders');

      if(!empty($param['slug']))
          $query->andWhere(['=', 'path', $param['slug']]);

      return $query;
    }

}
