<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Articles;
use app\modules\admin\models\ArticlesSearch;
use app\modules\admin\controllers\AController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\modules\admin\models\Links;
use app\modules\admin\models\Sources;
use app\modules\admin\models\ParsingRss;
use yii\data\Pagination;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends AController
{

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

		public function actionGetSlug($title)
		{
			$pathName = Articles::getNextName($title);
			echo json_encode(['slug'=>$pathName]);
		}


    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();
        $allCategory = Sources::allCategory();

        if ($model->load(Yii::$app->request->post())) {

            $idForLink = Yii::$app->request->post()['id-for-link'];

            if(!empty($_FILES['Articles']['name']['file']))
            {
                // Generate name for image
                $name_image = ParsingRss::setRandom();

                $model->file = UploadedFile::getInstance($model, 'file');
                $model->file->saveAs('uploads/articles/' . $name_image . '.' . $model->file->extension);
                $model->image = $name_image . '.' . $model->file->extension;
            }

            if(!empty($model->title))
            {
                $model->vendor_code = md5($model->title);
            }

            if($model->save())
            {
                Yii::$app->db->createCommand()
                 ->update('links', ['article_id' => $model->id], "article_id ='" . $idForLink . "'")
                 ->execute();
                 Yii::$app->db->createCommand()
                  ->update('article_category', ['article_id' => $model->id], "article_id ='" . $idForLink . "'")
                  ->execute();

            } else {
                Yii::$app->db->createCommand()
                ->delete('links', "status = '" . $idForLink . "'")
                 ->execute();
               Yii::$app->db->createCommand()
                ->delete('article_category', "status = '" . $idForLink . "'")
                ->execute();
            }
            return $this->redirect('/admin/articles');
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $allCategory,
            ]);
        }
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $links              = Links::getLinks($id);
        $allCategory        = Sources::allCategory();
        $allImages          = Articles::getImagesForArticle($id);
        $selectedCategories = Articles::getSelectedCategories($id);

        $mainImage = Articles::MainImage($id);

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if(!empty($_FILES['Articles']['name']['file'])) {
                 // Generate name for image
                 $name_image = ParsingRss::setRandom();

                 $model->file = UploadedFile::getInstance($model, 'file');
                 $model->file->saveAs('uploads/articles/' . $name_image . '.' . $model->file->extension);
                 $model->image = $name_image . '.' . $model->file->extension;
             }

             $model->edit_status = 1;
             $model->save();

            return $this->redirect('/admin/articles');
        } else {
            return $this->render('update', [
                'model' => $model,
                'links'=> $links,
                'categories'=> $allCategory,
                'selectedCategories' => $selectedCategories,
                'all_images'=> $allImages,
                'main_image'=> $mainImage,
            ]);
        }
    }


    public function actionChangeStatus()
    {
      $ids = $_REQUEST['ids'];
      $status = $_REQUEST['status'];
      Articles::changeStatus($ids, $status);

      return;
    }

    public function actionDeleteSelected()
    {
      $ids = $_REQUEST['ids'];

      $articles = new Articles();
      $articles->deleteByIds($ids);

      return ;
    }


    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionSetCathegory()
    {
        $post = $_POST;
        Articles::toggleCathegory($post);
    }

    // Upload images for articles in DB
    public function actionUploadImage()
    {
        $id_article = $_GET['id'];

        // Generate name for image
        $img = Sources::setRandom();
        //$img = $_POST['name'];

        $val = $_POST['value'];

        Articles::setUploadImages($img, $id_article, $val);
    }


}
