<?php

namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

use yii\filters\VerbFilter;

class AController extends Controller
{

	public function behaviors()
	{
			return [
					'access' => [
							'class' => AccessControl::className(),
							// 'only' => ['*'],
							'rules' => [
							[
									'allow' => false,
									'roles' => ['?'],
							],
							[
									'allow' => true,
									'roles' => ['@'],
							],
							],
					],
					'verbs' => [
							'class' => VerbFilter::className(),
							'actions' => [
									'delete' => ['post'],
							],
					],
			];
	}

	public function beforeAction($action)
	{
		$this->layout = "@app/views/layouts/admin";
		return parent::beforeAction($action);
	}

}
