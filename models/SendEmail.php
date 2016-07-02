<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%send_email}}".
 *
 * @property integer $id
 * @property string $email 255
 * @property string $text 1023
 * @property integer $create_date
 * @property integer $status
 */
class SendEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{send_email}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            [['email', 'text', 'create_date'], 'required'],
            [['id', 'status', 'create_date'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['text'], 'string', 'max' => 1023],
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/model', 'ID'),
            'email' => Yii::t('app/model', 'Email'),
            'text' => Yii::t('app/model', 'Text'),
            'status' => Yii::t('app/model', 'Status'),
            'create_date' => Yii::t('app/model', 'Create Date'),
        ];
    }
}
