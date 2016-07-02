<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

class Settings extends Model
{
  public $name;
  public $email;
  public $description;
  public $keywords;
  public $google_analitics;
  public $db_host;
  public $db_name;
  public $db_user;
  public $db_password;

	public $facebook_app_id;
  public $facebook_app_secret;
  /**
   * @return array the validation rules.
   */
  public function rules()
  {
      return [

          [['name', 'google_analitics', 'email'], 'string', 'max' => 128],
          [['db_host', 'db_name', 'db_user','facebook_app_secret','facebook_app_id'], 'string', 'max' => 64],
          [['db_password'], 'string', 'max' => 256],
          [['description', 'keywords'], 'safe'],

      ];
  }


  /*
  * Writing settings
  */
  public function setSettings($method)
  {
      $file = $_SERVER['DOCUMENT_ROOT'] . '/config/settings.txt';

      if($method == 'set')
      {
          $arr_settings = array(
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'google_analitics' => $this->google_analitics,
            'db_host' => $this->db_host,
            'db_name' => $this->db_name,
            'db_user' => $this->db_user,
            'db_password' => $this->db_password,
            'facebook_app_id' => $this->facebook_app_id,
            'facebook_app_secret' => $this->facebook_app_secret,
          );

          $sql = "DELETE FROM `settings` ";
          Yii::$app->db->createCommand($sql)->execute();

          foreach ($arr_settings as $key => $value) {
            Yii::$app->db->createCommand() ->insert('settings', [
                  'key' => $key,
                  'value' => $value,
              ])->execute();
          }

          // File record
          $content = json_encode($arr_settings);
          file_put_contents($file, $content);

          // Update connect to db
          $this->updateConnectToDb();


          return self::getSettings();
      }
      else
      {
          return self::getSettings();
      }

  }


  /*
  * Reading settings
  */
  public static function getSettings()
  {
      $file = $_SERVER['DOCUMENT_ROOT'] . '/config/settings.txt';

      $set = file_get_contents($file);
      $set = json_decode($set);

      return $set;
  }


  /*
  * Update connect to db
  */
  public function updateConnectToDb()
  {

      $path = $_SERVER['DOCUMENT_ROOT'] . '/config/environment_db.php';

      $content = '<?php
      define("DB_HOST", "'. $this->db_host .'");
      define("DB_NAME", "' . $this->db_name .'");
      define("DB_USERNAME", "' . $this->db_user .'");
      define("DB_PASSWORD", "' . $this->db_password .'");
      ?>';

      file_put_contents($path, $content);

      return true;
  }

}
