<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $subject
 * @property string $message
 */
class ContactUs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'site', 'subject', 'message', 'date_c'], 'required'],
            [['message'], 'string'],
            [['name'], 'string', 'max' => 256],
            [['email'], 'string', 'max' => 128],
            [['site'], 'string', 'max' => 1024],
            [['subject'], 'string', 'max' => 512],
            [['date_c'], 'string', 'max' => 32]
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
            'email' => 'Email',
            'site' => 'Site',
            'subject' => 'Subject',
            'message' => 'Message',
            'date_c' => 'Date',
        ];
    }

    /*
    * All contacts
    */
    public static function getAll()
    {
        $data = self::find()->orderBy('date_c DESC')->all();
        return $data;
    }

    /*
    * Edit color for read message
    */
    public static function editColor()
    {
        $sql = "UPDATE contact_us SET new_message = '0' WHERE new_message = '1'";
        Yii::$app->db->createCommand($sql)->execute();

        return true;
    }

}
