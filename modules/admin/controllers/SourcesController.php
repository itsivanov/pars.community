<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Sources;
use app\models\Articles;
use app\modules\admin\models\SourcesSearch;
use app\modules\admin\controllers\AController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\ParsingRss;
use app\modules\admin\models\Banners;

/**
 * SourcesController implements the CRUD actions for Sources model.
 */
class SourcesController extends AController
{
    /**
     * Lists all Sources models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourcesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $all_sources = Sources::getAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all_sources' => $all_sources,
        ]);
    }

    /**
     * Displays a single Sources model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sources model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sources();
        $allCategory = Sources::allCategory();

        if ($model->load(Yii::$app->request->post())) {
            $model['last_update'] = strtotime($model['last_update']);

            if($model->save())
            {
              $categories = Yii::$app->request->post()['category'];
              $categories[0] = $model->id;
              Sources::addCatForSources($categories);
            }

            return $this->redirect('/admin/sources');
        } else {
            $model->last_update = time();
            return $this->render('create', [
                'model' => $model,
                'allCategory' => $allCategory,
            ]);
        }
    }

    /**
     * Updates an existing Sources model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $allCategory = Sources::allCategory();

        $checkedCategory = Sources::getCategoryForBanners($id);

        if ($model->load(Yii::$app->request->post())) {

            $model['last_update'] = strtotime($model['last_update']);

            $model->save();

            return $this->redirect('/admin/sources');
        } else {

            if($model['last_update'] != 0)
            {
               $model['last_update'] = date('d-m-Y', $model['last_update']);
            }

            return $this->render('update', [
                'model' => $model,
                'allCategory' => $allCategory,
                'checkedCategory' => $checkedCategory,
            ]);
        }
    }

    /**
     * Deletes an existing Sources model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Sources::deleteCategoryes($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sources model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sources the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sources::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /*
    *  Categories for banner
    */
    public function actionAddCatForSources()
    {
        $categories = array_values($_POST['categories']);
        Sources::addCatForSources($categories);
    }


		public function actionParse($id)
    {
        $count = ParsingRss::parsingById($id);

				return $this->render('afterparse', [
						'count' => $count,
				]);
    }

    /*
    * Parsing posts from feed
    */
    public function actionSetparsing()
    {
        ParsingRss::parsing();
    }


    /*
    * Delete sources for ids
    */
    public function actionDeleteForIds()
    {
       Sources::deleteForIds($_POST['ids']);
    }


    /*
    *  Change status
    */
    public function actionChangeStatus($status)
    {
       Sources::changeStatus($_POST['ids'], $status, 'status');
    }

    public function actionChangeUpdateStatus($status)
    {
       Sources::changeStatus($_POST['ids'], $status, 'update_status');
    }

}
