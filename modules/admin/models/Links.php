<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Articles;

/**
 * This is the model class for table "links".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_id
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'article_id'], 'required'],
            [['article_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'article_id' => 'Article ID',
        ];
    }


    public function getArticles()
    {
        return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    }

    /*
    * Links for one article
    */
    public static function getLinks($val)
    {
        $links = self::find()
                      ->where(['article_id' => $val])
                      ->all();
        return $links;
    }

    /*
    * Add new links for article
    */
    public static function setLink($id, $links)
    {
        $sql_del = "DELETE FROM links WHERE article_id = '$id'";
        Yii::$app->db->createCommand($sql_del)->execute();

        if(!empty($links))
        {
            foreach($links as $key => $value)
            {
                if(!empty($value))
                {
                  $sql = "INSERT INTO links (name, article_id) VALUES ('$value', '$id')";
                  Yii::$app->db->createCommand($sql)->execute();
                }
            }
        }

    }

}
