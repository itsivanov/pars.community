<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $name
 * @property integer $main_category
 */
class Categories extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'main_category'], 'required'],
            [['main_category'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['meta_keywords', 'meta_description', 'text_above_content'], 'safe'],
        ];
    }

    /*
    * All categories
    */
    public static function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY category_order ASC";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        return $data;
    }

    public static function getParents()
    {
      $sql = "SELECT * FROM categories WHERE `parent_id`=0 ORDER BY category_order ASC";
      $data = Yii::$app->db->createCommand($sql)->queryAll();
      return $data;
    }


    public static function getOne($id)
    {
      $sql = "SELECT * FROM categories WHERE `id`='". $id ."' ";
      $data = Yii::$app->db->createCommand($sql)->queryOne();
      return $data;
    }

    public static function categoryOrder($data)
    {
        $sql = "UPDATE `categories` SET `category_order` = CASE `id` ";
        foreach ($data as $key => $value) {
            $sql .= " WHEN " . $key . " THEN  " . $value;
        }
        $sql .= " END";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }


    public static function sort($order)
    {
      $categories = (new \yii\db\Query())
            				->select(['*'])
            				->from('categories')
                    ->orderBy('category ' . $order)
            				->all();

      for($i=0; $i < count($categories); $i++)
      {

          Yii::$app->db->createCommand()->update('categories',
            ['category_order' => $i],
              'id = '.$categories[$i]['id'])->execute();
      }

      return true;
    }

    /*
    * Sort categories order parent
    */
    //public static function sortOrderParent($categories)
    // {
    //     $tree = [];
    //     for ($i=0; $i < count($categories); $i++) {
    //       $tree[$categories[$i]['parent_id']][] = $categories[$i];
    //     }
    //     return $tree;
    // }

    /*
    * Sort categories as tree
    */
    public static function sortAsTree($categories)
    {

      //$test = $categories;
      $menu = [];
      $children = [];
      foreach ($categories as $value) {
        if($value['parent_id'] == 0)
          $menu[$value['id']] = $value;
        else
          $children[$value['id']] = $value;
      }

      foreach ($children as $key => $value) {
        if(empty($menu[$value['parent_id']]))
          return false;

        if(empty($menu[$value['parent_id']]['child']))
          $menu[$value['parent_id']]['child'] = [];

        $menu[$value['parent_id']]['child'][] = $value;
      }
      /*
      $menu_index = array();

      for ($i=0; $i<count($test); $i++) {
          if($test[$i]['parent_id'] == 0) {
              $menu[] = $test[$i];
              $menu[sizeof($menu)-1]['child'] = array();
              $menu_index[$test[$i]['id']] = &$menu[sizeof($menu)-1];
          } else {
              $menu_index[$test[$i]['parent_id']]['child'][] = $test[$i];
              $menu_index[$test[$i]['id']] = &$menu_index[$test[$i]['parent_id']]['child'][sizeof($menu_index[$test[$i]['parent_id']]['child'])-1];
          }
      }
      var_dump($menu_index);
      */

      return $menu;

    }


    /*
    * Recursion for array tree
    */
    public static function recursionForArray($all_category, $parent = 0)
    {
        $content = '';

        if($parent)
        {
          $content .= '<ul class="hidden innerUl" data-parent="' . $parent . '">';
          $lvl = 2;
        }
        else
        {
          $content .= '<ul class="outerUl">';
          $lvl = 1;
        }
        foreach($all_category as $key => $cat)
        {
            $triangle = '';
            $class = "";
            if(isset($cat['child']) && count($cat['child'])>0)
            {
              $triangle="<div class='triangle left toggleInnerLi' data='" . $cat['id']  . "' ></div>";
              $class="toggleInnerLi";
            }

            $content .= '<li data="' . $cat['parent_id']  . '" id="' . $cat['id'] . '" class="' . $class . '"  >';
            $content .= $triangle;
            //$content .= ' <span class="sort lvl' . $lvl . '"></span>
            //            <span class="drag"></span>';

            if($cat['parent_id'] == 0)
              $content .= '<div class="main" id="main_' . $cat['id'] . '">';
            else
              $content .= '<div id="' . $cat['id'] . '">';

              $content .= '<span class="list_elem_title" data="' . $cat['id']  . '">' . $cat['category'] . '</span>';
              $content .= '<span class="activeButtons" id="buttom_plus_trash_' . $cat['id'] . '">';

              if($cat['parent_id'] == 0)
                $content .= '<span id="plus' . $cat['id'] . '" class="liAdd gl-plus-color" onClick="addFormInput(' . $cat['id'] . ')"></span>';
                
              $content .= '<span id="c_edit' . $cat['id'] . '" class="glyphicon glyphicon glyphicon-pencil gl-edit" onClick="editCategoryForm(' . $cat['id'] . ', ' . $cat['parent_id'] . ')"></span>';
              $content .= '<span id="trash' . $cat['id'] . '" class="liDel gl-trash" onClick="deleteCategory(' . $cat['id'] . ')"></span>';
              $content .= '</span>';
              $content .= '</div>';


            if(isset($cat['child']) && !empty($cat['child']))
                $content .= self::recursionForArray($cat['child'], $cat['id']);

            $content .= '</li>';
        }

        $content .= '</ul>';

        return $content;
    }


    /*
    * Add new category in db
    */
    public static function addCategory($data)
    {
        $sql = "INSERT INTO categories (`category`, `title`, `parent_id`, `meta_keywords`, `meta_description`, `text_above_content`)
                        VALUES ('" . $data['cat_name'] . "',
                                '" . $data['cat_title'] . "',
                                '" . $data['parent_cat'] . "',
                                '" . $data['cat_keywords'] . "',
                                '" . $data['cat_description'] . "',
                                '" . $data['cat_text_above'] . "') ";
        $data = Yii::$app->db->createCommand($sql)->execute();
        return true;
    }


    public static function editCategory($data)
    {

      $sql = "SELECT * FROM `categories` WHERE `id` ='" . $data['cat_id'] . "'";
      $one = Yii::$app->db->createCommand($sql)->queryOne();

      if($one['parent_id'] != $data['parent_cat'])
        $order = 0;
      else
        $order = $one['category_order'];


      $sql = "UPDATE `categories` SET `category`='" . $data['cat_name'] . "',
                                      `title`='" . $data['cat_title'] . "',
                                      `meta_keywords`='" . $data['cat_keywords'] . "',
                                      `meta_description`='" . $data['cat_description'] . "',
                                      `text_above_content`='" . $data['cat_text_above'] . "',
                                      `parent_id`='" . $data['parent_cat'] . "'
                                       WHERE `id`='" . $data['cat_id'] . "' ";

      $data = Yii::$app->db->createCommand($sql)->execute();
      return true;
    }

    /*
    * Delete category
    */
    public static function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id = '$id'";
        $data = Yii::$app->db->createCommand($sql)->execute();

        return true;
    }


}
