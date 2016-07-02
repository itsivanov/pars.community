<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\AController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\models\Settings;


/**
 * SettingsController
 */
class SettingsController extends AController
{

    public function actionIndex()
    {
      $model = new Settings;

      // Setting reading
      $arr = $model->setSettings('get');

      $model->name = $arr->name;
      $model->email = $arr->email;
      $model->description = $arr->description;
      $model->keywords = $arr->keywords;
      $model->google_analitics = $arr->google_analitics;
      $model->db_host = $arr->db_host;
      $model->db_name = $arr->db_name;
      $model->db_user = $arr->db_user;
      $model->db_password = $arr->db_password;

			if (!empty($arr->facebook_app_id)) {
				$model->facebook_app_id = $arr->facebook_app_id;
	      $model->facebook_app_secret = $arr->facebook_app_secret;
			}



      // Setting writing
      if (Yii::$app->request->post()) {
        $model->load(Yii::$app->request->post());

        $model->setSettings('set');
      }

      return $this->render('index',[
        'model' => $model,
      ]);

    }

}
