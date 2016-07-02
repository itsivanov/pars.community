<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\models\Articles;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row actions_row">

      <div class="col-md-12">
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success btn-margine']) ?>
      </div>
      <div class="col-md-2">
        <select class="form-control" id="article_action">
          <option value="statusEnable">Enable selected</option>
          <option value="statusDisable">Disable selected</option>
          <option value="delete">Delete selected</option>
        </select>
      </div>
      <div class="col-md-10">
        <?= Html::a('OK', ['#'], ['class' => 'btn btn-primary articles-do-btn']) ?>
      </div>

    </div>



    <?php Pjax::begin(['id'=>'articles-pjax']); ?>

    <?= GridView::widget([
        'id' => 'articles-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'columns' => [
          [
            'attribute' => '',
            'header'    => '<input type="checkbox" class="select_all_articles" />',
            'content'   => function($data)
            {
              return '<input type="checkbox" data-id="' . $data['id'] . '" class="articles_checkboxes" />';
            }
          ],
          /*
          [
            'attribute'=>'id',
            'contentOptions' => ['class'=>'id_row'],
          ],
          */
          [
            'attribute' => 'image',
            'contentOptions' => ['class'=>'td-img'],
            'content' => function($data)
            {
              return '<img src="/web/uploads/articles/' . $data['image'] . '" width="100px">';
            }
          ],

          'title',
          'vendor_code',
          'path',
          [
            'attribute'=>'create_time',
            'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,
                                                     'attribute'=>'create_time',
                                                     'dateFormat' => 'yyyy-MM-dd']),
            'content'=>function($data){
                return date('Y-m-d H:i:s', $data['create_time']);
            }
          ],



          [
            'attribute' => 'status',
            'filter' => $searchModel->statuses,
            'content' => function($data)
            {
              if($data['status'] != 0)
                return 'Enabled';
              else
                return 'Disabled';
            }
          ],

          [
            'attribute' => 'edit_status',
            'filter' => Articles::$edit_status,
            'content' => function($data)
            {
              return Articles::$edit_status[$data['edit_status']];
            }
          ],

          [
            'attribute'=>'categories',
            'header'=>'Categories',
            'content'=>function($data){

                return Articles::getCategories($data['id']);
            }
          ],


          [
            'attribute'=>'sources',
            'header'=>'Sources',
            'content'=>function($data){

                return Articles::getSourses($data['id']);
            }
          ],

          [
            'header'=>'Actions',
            'content'=>function($data){

                return  '<a href="/admin/articles/update?id=' . $data['id'] . '" title="Update" aria-label="Update" data-pjax="0">
                      <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a class="del-btn" href="/admin/articles/delete?id=' . $data['id'] . '" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                      <span class="glyphicon glyphicon-trash"></span>
                  </a>';
            }
          ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

  <?php $this->registerJsFile('@web/js/backend/articles_checkboxes.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
</div>
