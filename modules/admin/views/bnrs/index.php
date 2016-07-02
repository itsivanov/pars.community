<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\Banners;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BannersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("

", View::POS_END, 'search');

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;

$blocks = [
    '1' => 'Left banner',
    '2' => 'Top banner',
    '3' => 'Right banner',
    '4' => 'Bottom banner',
]
?>
<div class="banners-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php if($bannersDue > 1) : ?>
      <div class="due_date__banners">
        There are <?= $bannersDue ?> banners which will expire soon
      </div>
    <?php endif; ?>

    <?php if($bannersDue  == 1) : ?>
      <div class="due_date__banners">
        There are 1 banner which will expire soon
      </div>
    <?php endif; ?>

    <?= Html::a('Create Banners', ['create'], ['class' => 'btn btn-success btn-margine']) ?>
    <?= Html::a('Delete selected', ['#'], ['class' => 'btn btn-danger btn-margine banner-delete-btn']) ?>


    <?php Pjax::begin(['id'=>'banners-pjax']); ?>

    <?= GridView::widget([
        'id' => 'banners-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'rowOptions' => function ($model){
            if(($model['due_date'] - time()) < (3600 * 24 * 4) && !empty($model['due_date'])) {
              return ['class' => 'due_soon'];
            } else {
              return [];
            }
          },
        'columns' => [
          [
            'attribute' => '',
            'header'    => '<input type="checkbox" class="select_all_banners" />',
            'content'   => function($data)
            {
              return '<input type="checkbox" data-id="' . $data['id'] . '" class="banner_checkboxes" />';
            }
          ],
          [
            'attribute'=>'id',
            'contentOptions' => ['class'=>'id_row'],
          ],
          [
            'attribute'=>'banner',
            'format'=>'html',
            'contentOptions' => ['class'=>'table_banner'],
            'content'=>function($data){
                return $data['banner'];
            }
          ],
          [
              'attribute' => 'title',
              'filter' => AutoComplete::widget([
              'model' => $searchModel,
              'attribute' => 'title',
              'clientOptions' => [
                   'source' => '/admin/bnrs/autocomplete-title',
                   'dataType'=>'json',
                   'autoFill'=>true,
                   'minLength'=>'3',
                   'select' =>new JsExpression("function(event, ui) {
                     $('#bannerssearch-title').val(ui.item.value);
                     $('#bannerssearch-title').trigger('change');
                   }"),
                ],
              ]),
          ],

          [
            'attribute'=>'nummer_block',
            'filter'=>Banners::$blocks_name,
            'content'=>function($data){
                return Banners::$blocks_name[$data['nummer_block']];
            }
          ],

          [
            'attribute'=>'status',
            'filter'=> ['2' => 'Disable', '1' => 'Enable'],
            'content'=>function($data){
                $status = ['0' => 'Disable', '1' => 'Enable'];
                return $status[$data['status']];
            }
          ],

          [
            'attribute'=>'create_date',
            'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,
                                                     'attribute'=>'create_date',
                                                     'dateFormat' => 'yyyy-MM-dd']),
            'content'=>function($data){
                return date('Y-m-d H:i:s', $data['create_date']);
            }
          ],

          [
            'attribute'=>'due_date',
            'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel,
                                                     'attribute'=>'due_date',
                                                     'dateFormat' => 'yyyy-MM-dd']),
            'content'=>function($data){
                return date('Y-m-d H:i:s', $data['due_date']);
            }
          ],

          [
            'attribute'=>'categories',
            'header'=>'Categories',
            'filter' => AutoComplete::widget([
              'model' => $searchModel,
              'attribute' => 'categories',
              'clientOptions' => [
                   'source'   => Banners::getAllCategories(),
                   'autoFill' => true,
                   'minLength'=> '2',
                   'select'   => new JsExpression("function(event, ui) {
                     $('#bannerssearch-categories').val(ui.item.value);
                     $('#bannerssearch-categories').trigger('change');
                   }"),
                ],
              ]),
              'content'=>function($data){
                  return Banners::getCategories($data['id']);
              }
          ],


          [
            'attribute'=>'sources',
            'header'=>'Sources',
            'filter' => AutoComplete::widget([
              'model' => $searchModel,
              'attribute' => 'sources',
              'clientOptions' => [
                   'source'   => Banners::getAllSources(),
                   'autoFill' => true,
                   'minLength'=> '2',
                   'select'   => new JsExpression("function(event, ui) {
                     $('#bannerssearch-sources').val(ui.item.value);
                     $('#bannerssearch-sources').trigger('change');
                   }"),
                ],
              ]),
              'content'=>function($data) {
                  return Banners::getSourses($data['id']);
              }
          ],

          [
            'header'=>'Actions',
            'content'=>function($data){

                return  '<a href="/admin/bnrs/update?id=' . $data['id'] . '" title="Update" aria-label="Update" data-pjax="0">
                      <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a class="del-btn" href="/admin/bnrs/delete?id=' . $data['id'] . '" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                      <span class="glyphicon glyphicon-trash"></span>
                  </a>';
            }
          ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <!--
    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><span class="tab-title">Image</span></th>
                    <th><span class="tab-title">Nummer Block</span></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($all_banners as $item) : ?>
                <tr data-key="12">
                    <td>
                      <?php echo strip_tags($item->banner); ?>
                    </td>
                    <td><?php echo $blocks[$item->nummer_block]; ?></td>
                    <td>
                        <a href="/admin/bnrs/update?id=<?php echo $item->id; ?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/admin/bnrs/delete?id=<?php echo $item->id; ?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>-->


  <?php $this->registerJsFile('@web/js/backend/banners_checkboxes.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
</div>
