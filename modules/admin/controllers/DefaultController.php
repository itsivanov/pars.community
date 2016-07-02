<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\AController;

use app\modules\admin\models\LoginForm;
use app\modules\admin\models\Articles;
use app\modules\admin\models\XML;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends AController
{

	public function behaviors()
	{
			return [
					'access' => [
							'class' => AccessControl::className(),
							'only' => ['index','logout'],
							'rules' => [
									[
											'actions' => ['index','logout'],
											'allow' => true,
											'roles' => ['@'],
									],
									[
										'actions' => ['index','logout'],
										'allow' => false,
										'roles' => ['?'],
									]
							],
					],
					// 'verbs' => [
					// 		'class' => VerbFilter::className(),
					// 		'actions' => [
					// 				'logout' => ['post'],
					// 		],
					// ],
			];
	}

    public function actionIndex()
    {
        return $this->render('index');
    }

		public function actionLogin()
		{

				if (!\Yii::$app->user->isGuest) {
						return $this->goHome();
				}

				$model = new LoginForm();
				if ($model->load(\Yii::$app->request->post()) && $model->login()) {
						//return $this->goBack();
						return $this->redirect('/admin/default/index',302);
				}
				return $this->render('login', [
						'model' => $model,
				]);
		}

		public function actionLogout()
		{
				\Yii::$app->user->logout();

				return $this->redirect('/',302);
		}

		public function actionGeneratePath($test = false)
		{
			if(!$test)
				return;

			$query = (new \yii\db\Query())
				->select(['*'])
				->from('articles')
				->where("path=''")
				->orderBy('id DESC');
			$cnt = $query->count();
			for($offset = 0; $offset <= ($cnt + 200); $offset = $offset + 200) {
				$data = (new \yii\db\Query())
					->select(['`id`, `title`, `path`'])
					->from('articles')
					->where("path=''")
					->orderBy('id DESC')
					->limit(200)
					->all();

					foreach ($data as $value) {
							$pathName = Articles::getNextName($value['title']);
							\Yii::$app->db->createCommand()
										 ->update('articles', ['path' => $pathName], 'id = ' . $value['id'])->execute();
					}

			}

			exit();
		}
}
