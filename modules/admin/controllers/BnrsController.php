<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Banners;
use app\modules\admin\models\BannersSearch;
use app\modules\admin\controllers\AController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BnrsController extends AController
{
    /**
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $bannersDue = $searchModel->bannersDue();
        $all_banners = Banners::getAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all_banners' => $all_banners,
            'bannersDue' => $bannersDue,
        ]);
    }

    /**
     * Displays a single Banners model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionDeleteBannersAjax()
    {
      $ids = ( !empty($_REQUEST['ids']) ) ? $_REQUEST['ids'] : [];

      foreach ($ids as $id) {
        Banners::deleteBannerFromSources($id);
        Banners::deleteBannerFromCategories($id);
        $this->findModel($id)->delete();
      }

      return true;
    }


    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * Creates a new Banners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model       = new Banners();
        $allCategory = Banners::allCategory();
        $allSources  = Banners::allSources();


        $model->due_date = time() + (3600 * 24 * 30);

        if ($model->load(Yii::$app->request->post())) {
           $model->categories = !empty($_REQUEST['Banners']['categories']) ? $_REQUEST['Banners']['categories'] : '';
           $model->sources = !empty($_REQUEST['Banners']['sources']) ? $_REQUEST['Banners']['sources'] : '';
           $model->due_date = strtotime($model->due_date);


          if($model->save()) {
            Banners::addCatForBanner($model->categories, $model->id);
            Banners::addSrcForBanner($model->sources, $model->id);
          }

            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect('/admin/bnrs');

        } else {
            return $this->render('create', [
                'model' => $model,
                'allCategory'     => $allCategory,
                'allSources'      => $allSources,
            ]);
        }
    }

    /**
     * Updates an existing Banners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //$image = Banners::getOne($id);

        if(empty($model->due_date))
          $model->due_date = time() + (3600 * 24 * 30);

        $allCategory = Banners::allCategory();
        $checkedCategory = Banners::getCategoryForBanners($id);

        $allSources = Banners::allSources();
        $checkedSources = Banners::getSourcesForBanners($id);


        $categories = [];
        if(!empty($checkedCategory[0])) {
          foreach ($checkedCategory as $value) {
            $categories[] = $value['category_id'];
          }
        }

        $sources = [];
        if(!empty($checkedSources[0])) {
          foreach ($checkedSources as $value) {
            $sources[] = $value['source_id'];
          }
        }

        $model->categories = implode(',', $categories);
        $model->sources = implode(',', $sources);

        if ($model->load(Yii::$app->request->post())) {

            if(!empty($_FILES['Banners']['name']['file']))
             {
                 $model->file = UploadedFile::getInstance($model, 'file');
                 $model->file->saveAs('uploads/banners/' . $model->file->baseName . '.' . $model->file->extension);
                 $model->image = $model->file->baseName . '.' . $model->file->extension;
             }

             $model->due_date = strtotime($model->due_date);

             $model->categories = !empty($_REQUEST['Banners']['categories']) ? $_REQUEST['Banners']['categories'] : '';
             $model->sources = !empty($_REQUEST['Banners']['sources']) ? $_REQUEST['Banners']['sources'] : '';

             Banners::addCatForBanner($model->categories, $id);
             Banners::addSrcForBanner($model->sources, $id);

             $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'image' => $image,
                'allCategory'     => $allCategory,
                'checkedCategory' => $checkedCategory,
                'allSources'      => $allSources,
                'checkedSources'  => $checkedSources,
            ]);
        }
    }

    /**
     * Deletes an existing Banners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Banners::deleteBannerFromSources($id);
        Banners::deleteBannerFromCategories($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAutocompleteTitle()
    {
      $banners = new Banners();
      $banners_data = $banners->getByTitle($_REQUEST['term']);

      echo json_encode($banners_data);
      exit();
    }


    /*
    *  Categories for banner
    */
    /*
    public function actionAddCatForBanner()
    {
        if(!is_array($_POST['categories']))
          $_POST['sources'] = [];

        $categories = array_values($_POST['categories']);
        Banners::addCatForBanner($categories);
    }

    public function actionAddSrcForBanner()
    {
        if(!is_array($_POST['sources']))
          $_POST['sources'] = [];

        $sources = array_values($_POST['sources']);
        Banners::addSrcForBanner($sources);
    }
    */
}
