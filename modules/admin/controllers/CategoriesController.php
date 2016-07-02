<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Categories;
use app\modules\admin\models\CategoriesSearch;
use app\modules\admin\controllers\AController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends AController
{

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $all_category = Categories::getAll();
        $parents_category = Categories::getParents();
        $all_category = Categories::sortAsTree($all_category);

        return $this->render('index', [
          'all_category' => $all_category,
          'parents_category' => $parents_category
        ]);
    }


    /*
    * Select all categories for ajax
    */
    public static function getCategoriesForAjax()
    {
        $all_category = Categories::getAll();
        $all_category = Categories::sortAsTree($all_category);
        return Categories::recursionForArray($all_category);
    }


    public static function actionSortingCategory()
    {
        $data = $_POST['data'];
        $result = Categories::categoryOrder($data);
        return $result;
    }

    /*
    * Add new category
    */

    // public function actionAddNewCategory()
    // {
    //     if(isset($_POST['nameCat']))
    //     {
    //       $id = 0;
    //       $name_cat = htmlspecialchars(strip_tags(trim($_POST['nameCat'])));
    //     }
    //     else
    //     {
    //       $id = (int)$_POST['id'];
    //       $name_cat = htmlspecialchars(strip_tags(trim($_POST['name'])));
    //     }
    //     $add = Categories::addCategory($id, $name_cat);
    //
    //     if($add)
    //     {
    //         echo self::getCategoriesForAjax();
    //     }
    // }

    public function actionGetAllInfo()
    {
        $id = (!empty($_REQUEST['id'])) ? addslashes(trim($_REQUEST['id'])) : false;
        if(!$id)
          return false;

        $cat = Categories::getOne($id);
        echo json_encode($cat);
        exit();
    }

    public function actionEditCategory()
    {
      $data = [];
      foreach ($_POST as $key => $value) {
        $data[$key] = addslashes(trim($value));
      }

      if($data['parent_cat'] == $data['cat_id'])
        $data['parent_cat'] = 0;

      if(!$data['cat_id'] && !$data['cat_name'])
        return false;

      if(empty($data['cat_id']) && !empty($data['cat_name']))
        $result = Categories::addCategory($data);
      else
        $result = Categories::editCategory($data);

      if($result)
        echo json_encode(['success' => 1]);

    }

    public function actionSort()
    {
      if(empty($_REQUEST['sort']))
      {
        echo json_encode(['error' => 'empty sort direction']);
        return;
      }

      $sorting = Categories::sort($_REQUEST['sort']);
      echo $result = self::getCategoriesForAjax();
      exit();
    }

    /*
    * Delete category
    */
    public function actionDeleteCategory()
    {
        $id = (int)$_POST['id'];
        $del = Categories::deleteCategory($id);

        if($del)
        {
            echo self::getCategoriesForAjax();
        }

    }

}
