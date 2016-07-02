<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SourcesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="row actions_row">

      <div class="col-md-12">
        <?= Html::a('Create Sources', ['create'], ['class' => 'btn btn-success btn-margine']) ?>
      </div>
      <div class="col-md-2">
        <select class="form-control" id="sources_action">
          <option value="statusActive">Active selected</option>
          <option value="statusInactive">Inactive selected</option>
          <option value="statusPublished">Published selected</option>
          <option value="statusUnpublished">Unpublished selected</option>
          <option value="delete">Delete</option>
        </select>
      </div>
      <div class="col-md-10">
        <?= Html::a('OK', ['#'], ['class' => 'btn btn-primary sources-do-btn']) ?>
      </div>

    </div>


    <div class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select_all_sources"></th>
                    <th><span class="tab-title">Name</span></th>
                    <th><span class="tab-title">Site url</span></th>
                    <th><span class="tab-title">Feed Url</span></th>
                    <th><span class="tab-title">Update Status</span></th>
                    <th><span class="tab-title">Status</span></th>
                    <th><span class="tab-title">Update On</span></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($all_sources as $item) : ?>
                <tr id="<?php echo $item->id; ?>" data-key="12">
                    <td><input type="checkbox" data-id="<?php echo $item->id; ?>" class="sources_checkboxes"></td>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->site_url; ?></td>
                    <td><?php echo $item->feed_url; ?></td>
                    <td class="update_status"><?php echo ($item->update_status == "1") ? "Active" : "Inactive"; ?></td>
                    <td class="status"><?php echo ($item->status == "1") ? "Published" : "Unpublished"; ?></td>
										<td><?php echo date("Y-m-d H:i:s",$item->last_update); ?></td>
                    <td>
                        <a href="/admin/sources/update?id=<?php echo $item->id; ?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/admin/sources/delete?id=<?php echo $item->id; ?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
												<a href="/admin/sources/parse?id=<?php echo $item->id; ?>" title="Parse" aria-label="Parse" data-confirm="Are you sure to parse this feed" data-method="post" data-pjax="0">
														<span class="glyphicon glyphicon-cloud-download"></span>
												</a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>

<?php $this->registerJsFile('@web/js/backend/sources_checkboxes.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
