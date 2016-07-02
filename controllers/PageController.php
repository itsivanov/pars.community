<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Page;
use app\models\Articles;
use app\models\Category;

class PageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($path)
    {
			$one           = Articles::getOneByPath($path);
			if (empty($one)) throw new \yii\web\NotFoundHttpException();

			$links         = Articles::getLinksToOne($one['id']);
			$categories    = Page::categoryForOneArticle($one['id']);
			$related_posts = Articles::getRandom($one['id']);

      $banners       = Page::getBanners($categories);

			return $this->render('index', [
					'item'          => $one,
					'related_posts' => $related_posts,
					'categories'    => $categories,
					'links'         => $links,
          'banners'       => $banners,
			]);
    }

}
