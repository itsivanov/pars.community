<?php

  use yii\web\View;
  use yii\helpers\Html;
  use yii\grid\GridView;

  $this->title = "Static Pages";



  $this->registerJs("


    $('.static_pages table tbody').sortable({
       placeholder: 'ui-state-highlight',
       cursor: 'move',
       helper: function(e, ui) {
         ui.children().each(function() {
             $(this).width($(this).width());
         });
         return ui;
       },
    }).disableSelection();

    saveOrder = function()
    {
        /*update: function(event,ui) {*/
          var data = [];
          $('.pages_row').each(function(){
            data[data.length] = $(this).attr('data-id')
          });

          $.ajax({
              type: 'POST',
              url: '/admin/static-pages/sorting-pages',
              data: {data:data},
          }).success(function(data){
             /*$.fn.yiiGridView.update('#static-pages-grid');*/
             window.location.href='/admin/static-pages/index';
          });
       /*}*/
    }

  ", View::POS_END, 'sorting');
?>


<div class="content">
  <h1>Static Pages</h1>

  <a href="/admin/static-pages/create">
    <span class="btn btn-success" id="create_page">
      Create new page
    </span>
  </a>

  <span class="btn btn-primary" id="save_order" onClick="saveOrder(); return false;">
    Save order
  </span>


<div class="static_pages">

<?= GridView::widget([
    'id' => 'static-pages-grid',
    'dataProvider' => $dataProvider,
    'layout'=>"{items}\n{pager}",
    'rowOptions' => function ($model, $key, $index, $grid) {
              return ['data-id' => $model['id'], 'class' => 'pages_row'];
    },
    'columns' => [
        'id',
        'title',
        'path',
        [
          'attribute'=>'data',
          'format' => 'raw',
          'content'=>function($data){
              $return = strip_tags($data['data']);
              if(strlen($data['data']) > 50)
                $return = substr(strip_tags($data['data']), 0, 50) . '...';

              return $return;
          }
        ],

        [
          'attribute'=>'update_date',
          'content'=>function($data){
              return date('Y-m-d H:i:s', $data['update_date']);
          }
        ],
        [
          'attribute'=>'meta_keyword',
          'content'=>function($data){
              $return = $data['meta_keyword'];
              if(strlen($data['meta_keyword']) > 50)
                $return = substr($data['meta_keyword'], 0, 50) . '...';

              return $return;
          }
        ],
        [
          'attribute'=>'meta_description',
          'content'=>function($data){
              $return = $data['meta_description'];
              if(strlen($data['meta_description']) > 50)
                $return = substr($data['meta_description'], 0, 50) . '...';

              return $return;
          }
        ],
        [
          'attribute'=>'orders',
          'content'=>function($data){
              return $data['orders'] + 1;
          }
        ],

        //['class' => 'yii\grid\ActionColumn'],
        [
            'content' => function ($model, $key, $index, $column) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model['id']])
                    . Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['data-method'=> 'post', 'class' => '',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ]]);
            }
        ]

    ],
]); ?>

</div>

</div>
