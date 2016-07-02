<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Articles */

$this->title = 'Update Articles: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="articles-update">

    <h1><?= Html::encode($this->title) ?></h1>

		<div class="">
			<div class="">
				<a class="grid-btn grid-btn-link"  href="<?php echo Url::to(['/page/index','id'=>$model->id]); ?>" title="View" target="_blank" aria-label="View" data-pjax="0">View on site</a>
			</div>

			<?php if (!empty($model->source_id)) :?>
			<div class="">
				<a class="grid-btn grid-btn-link" href="/admin/sources/update?id=<?php echo $model->source_id; ?>" title="Source" aria-label="Source" data-pjax="0">Source</a>
			</div>
			<?php endif;?>
		</div>


    <div class="articles-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

          <?= $this->render('_form', [
              'model' => $model,
              'form' => $form,
          ]) ?>

          <?php ActiveForm::end(); ?>

    </div>

          <!-- Categories -->
          <div class="row categories_list">
          <?php foreach($categories as $item) : ?>
              <div class="cat_b">
                  <div class="cat_row"><?php echo $item['category']; ?></div>
                  <div class="cat_row2">
                  <?php if(in_array($item['id'], $selectedCategories)) : ?>
                      <input type="checkbox" class="art_cat_for_banner" value="<?php echo $item['id']; ?>" checked="checked" />
                  <?php else : ?>
                      <input type="checkbox" class="art_cat_for_banner" value="<?php echo $item['id']; ?>" />
                  <?php endif; ?>
                  </div>
              </div>
          <?php endforeach; ?>
          </div>


			<!-- Links -->

      <h1>Links</h1>
      <div class="reference">
        <form method="post" id="form-links">
            <table id="table_container">

                <?php if(!empty($links)) : ?>

                    <?php $num = 1; ?>
                    <?php foreach($links as $item) : ?>

                        <tr id="tr_image_1">
                            <td id="td_title_1" style="padding-right: 5px; width: 200px;">
                                <input class="ln form-control" type="text" id="input_title_10<?php echo $num; ?>" name="input_title_10<?php echo $num; ?>" style="width: 200px;" value="<?php echo $item->name; ?>" />
                            </td>
                            <td style="width: 60px;">
                                <span id="progress_1" class="padding5px">
                                    <a onclick="$('#tr_image_1').remove();" class="ico_delete">
                                        <img src="/web/uploads/others/delete.png" alt="del" border="0">
                                    </a>
                                </span>
                            </td>
                        </tr>

                    <?php $num++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    There is no reference
                <?php endif; ?>

          		</table>
          		<input type="button" value="+" id="add" class="plus" onclick="return add_new_image();">
          		<input type="hidden" class="id-for-link" value="<?php echo $model->id; ?>">

              <div class="form-group but-bnt">
                  <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary add-link-ajax']) ?>
              </div>

          </form>

          <?= Html::a('Delete', ['delete', 'id' => $model->id], [
              'class' => 'btn btn-danger additionaly-but-del pos-additionaly',
              'data' => [
                  'confirm' => 'Are you sure you want to delete this item?',
                  'method' => 'post',
              ],
          ]) ?>

      </div>

    <!-- > -->


</div>
