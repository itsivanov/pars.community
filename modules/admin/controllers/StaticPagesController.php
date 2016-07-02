<?php

namespace app\modules\admin\controllers;


use Yii;
use app\modules\admin\controllers\AController;
use app\modules\admin\models\Pages;
use app\modules\admin\models\Articles;

class StaticPagesController extends AController
{

    public function actionIndex()
    {
      $model = new Pages();
      $dataProvider = $model->findAllPages();

      return $this->render('index', [
        'model'        => $model,
        'dataProvider' => $dataProvider,
      ]);
    }

    public function actionCreate()
    {
      $model = new Pages();
      $model->update_date = time();

      if(!empty(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
        if($model->save())
          $this->redirect('index');
      }

      return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
      $model = $this->findModel($id);

      if(!empty(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
        $model->update_date = time();
        if($model->save())
          $this->redirect('index');
      }

      return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionCheckSlug()
    {
       $title = $_REQUEST['title'];
       $pathName = Pages::checkSlug($title);
       echo json_encode(['slug'=>$pathName]);
       exit();
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionSortingPages()
    {
        if(empty($_REQUEST['data']))
          return false;

        $data = $_REQUEST['data'];
        Pages::setOrder($data);
    }

    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
