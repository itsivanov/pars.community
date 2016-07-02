<?php

/* @var $this yii\web\View */

use yii\grid\GridView;

$this->title = 'Emails';

?>
<div class="site-index">
	<?php 

		echo GridView::widget([
		    'dataProvider' => $dataProvider,
			'layout'=>"{items}\n{pager}",
			'tableOptions' => [
		        'class' => 'table table-bordered table-striped table-responsive',
		    ],
		    'columns' => [
					"id",
					"email",
					"text",
					"status",
					[
					 	'attribute' => 'create_date',
					    'label' => 'Data',
					    'content'=>function ($model, $key, $index, $column) {
					        return date("Y-m-d H:i:s", $model['create_date']);
					    }
					],
					['class' => 'yii\grid\ActionColumn'],
			],
		]);

	?>
</div>
