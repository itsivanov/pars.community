<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SendEmail;
use app\helper\Helper;
use app\models\Articles;
use app\models\Category;
use \yii\helpers\Url;
use app\modules\admin\models\ParsingRss;
use app\models\Search;
use app\models\StaticPages;

class SiteController extends Controller
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


    public function actionIndex($slug = false)
    {
      if(!empty($slug))
      {
        $page = StaticPages::getOne($slug);

        if(empty($page))
          $this->redirect('/', 302);

        return $this->render('static_page', ['page' => $page]);
      }
      $all_articles = Articles::getAll(['category'=>'Watches']);
      return $this->render('index', [
        'all_articles' => $all_articles['data'],
				'page'         => 1,
        'pages'        => $all_articles['pages'],
      ]);
    }


    public function actionRss($category = false)
    {
        header("Content-Type: application/xml; charset=ISO-8859-1");
        echo $rss = Articles::getRss($category);
        exit();
     }

		/*
		* Link more (articles)
		*/
		public function actionLinkMore($page)
		{
			$category = Yii::$app->request->get('category');
			$search   = Yii::$app->request->get('search');

			$ajax     = Yii::$app->request->get('ajax', false);

			$articles = Articles::LinkMore($page, ['category'=>$category,'search'=>$search]);


			if (!empty($articles['data'])) {

				if ($ajax === false) {

					if (empty($category) && empty($search)) {
						return $this->render('page',[
							'all_articles' => $articles['data'],
							'page'         => $page,
							'pages'        => $articles['pages'],
						]);
					} else {

						return $this->render('category', [
							'all_articles' => $articles['data'],
							'page'         => $page,
							'pages'        => $articles['pages'],
							'one_category' => (!empty($search)) ? $search : $category,
							'is_search'    => (!empty($search)) ? true : false,
						]);

					}



				} else {
					return $this->renderPartial('_content',[
						'articles'     => $articles['data'],
						'page'         => $page,
						'pages'        => $articles['pages'],
					]);
				}

			} else {

				if ($ajax === false) {
					throw new \yii\web\NotFoundHttpException();
				} else {
					echo 0;
				}

			}
		}


		/*
    *  Select all sources (articles) from one category
    */
    public function actionCategory($category)
    {
				$categoryData = Category::getOneByName($category);
        $categoryBanner = Category::getBanners($category);
				$articlesOneCat = Articles::getSourcesOneCategory($category);

        return $this->render('category', [
          'all_articles'       => $articlesOneCat['data'],
					'page'               => 1,
          'pages'              => $articlesOneCat['pages'],
          'one_category'       => $category,
          'categoryData'       => $categoryData,
          'banner'             => $categoryBanner,
        ]);
    }

		public function actionSearch($search_req)
		{

			$articles = Articles::findFirst($search_req);

			return $this->render('category', [
				'all_articles' => $articles['data'],
				'page'         => 1,
				'pages'        => $articles['pages'],
				'one_category' => $search_req,
				'is_search'    => true,
			]);
		}




    // -------------------------------------------------------------------------

    public function actionEmailSend()
    {

        if(empty($_REQUEST['ajax']))
        {
            echo json_encode(['success'=>0, 'text'=>'is not ajax report']);
            exit();
        }
        if(empty($_REQUEST['email']) || empty($_REQUEST['email-text']))
        {
            echo json_encode(['success'=>0, 'text'=>'field can`t be empty']);
            exit();
        }

        $model = new SendEmail();

        $model->email = Helper::postFilter($_REQUEST['email']);
        $model->text = Helper::postFilter($_REQUEST['email-text']);
        $model->create_date = time();
        $model->status = 0;

        if($model->save())
        {
            $out['success'] = 1;
            $out['text'] = 'email sent success';
        }
        else
        {
            $out['success'] = 0;
            $out['text'] = 'data not sent';
        }

        echo json_encode($out);

        die();
    }

    public function actionLogin()
    {
        /*
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect('/admin/index',302);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


		/*
    * Circumcision white edges in images
    * ( /site/cutting-white-edges for cron )
    */
    public function actionCuttingWhiteEdges()
    {
         $sql = "SELECT id, image FROM articles WHERE emarginate = '0' ORDER BY id DESC LIMIT 100";
         $images = Yii::$app->db->createCommand($sql)->queryAll();

         foreach($images as $item)
         {
              $name = $item['image'];

              $folder = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/';
              $config = array("source"=>$folder . $name,"save"=>$_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/',"borderColor"=>0xFFFFFF,"accuracy"=>10, 'name'=>$name);
              $success = Yii::$app->cropimage->removeBorders($config);

              $file = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/crop.log',
                          implode(', ', ['id' => $item['id'], 'imageOld' => $name, 'result' => $success, 'date' => date('Y-m-d H:i:s', time()) ]) . ' \n', FILE_APPEND);
              if($success)
              {
                  $id = $item['id'];
                  if($name != $success)
                  {
                    unlink($folder . $name);
                  }
                  $sql = "UPDATE articles SET `image`='" . $success . "', emarginate = '1' WHERE id = '$id'";
                  Yii::$app->db->createCommand($sql)->execute();
              }
              else {
                $id = $item['id'];
                $sql = "UPDATE articles SET emarginate = '1' WHERE id = '$id'";
                Yii::$app->db->createCommand($sql)->execute();
              }
         }

    }

    /*
    * Parsing posts from feed
    */
    public function actionSetParsing()
    {
        // $feed = trim($_POST['feed']);
        // Sources::setParsing($feed);

        ParsingRss::parsing();
    }

    public function actionGenereteArticlesCategory()
    {
        $sql = "SELECT count(*) as cnt FROM articles a
                  LEFT JOIN category_for_articles cfa ON cfa.source_id = a.source_id";
        $count = Yii::$app->db->createCommand($sql)->queryScalar();

        for($i = 0; $i < $count; $i = $i + 200)
        {
          $sql = "SELECT a.id, cfa.category_id FROM articles a
                    LEFT JOIN category_for_articles cfa ON cfa.source_id = a.source_id LIMIT " . $i . ", 200;";
          $data = Yii::$app->db->createCommand($sql)->queryAll();
          Yii::$app->db->createCommand()->batchInsert('article_category', ['article_id', 'category_id'], $data)->execute();
        }
    }

}
