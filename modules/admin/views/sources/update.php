<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Sources */

$this->title = 'Update Sources: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sources-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <input type="hidden" class="id_m" value="<?php echo $model->id; ?>" />

    <!-- < Categories -->
          <label class="control-label">Categories</label>

          <!-- < Array checked categories -->
          <?php
          if(!empty($checkedCategory))
          {
              foreach ($checkedCategory as $item)
              {
                  $ckeckedItem[] = $item['category_id'];
              }
          }
          ?>
          <!-- > -->

          <div class="selected_cat">

          <input type="submit" class="select_all" value="Select all" />
          <input type="submit" class="unselect_all" value="Unselect all" />

          <div class="row categories_list">
          <?php foreach($allCategory as $item) : ?>
              <div class="cat_b">
                  <div class="cat_row"><?php echo $item['category']; ?></div>
                  <div class="cat_row2">
                  <?php if(!empty($checkedCategory)) : ?>

                      <?php if(in_array($item['id'], $ckeckedItem)) : ?>
                          <input type="checkbox" class="cat_for_banner" value="<?php echo $item['id']; ?>" checked="checked" />
                      <?php else : ?>
                          <input type="checkbox" class="cat_for_banner" value="<?php echo $item['id']; ?>" />
                      <?php endif; ?>

                  <?php else : ?>
                      <input type="checkbox" class="cat_for_banner" value="<?php echo $item['id']; ?>" />
                  <?php endif; ?>

                  </div>
              </div>
          <?php endforeach; ?>
          </div>
          </div>
      <!-- > -->

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success add-cat-for-sources' : 'btn btn-primary add-cat-for-sources']) ?>
          <?= Html::a($model->isNewRecord ? '' : 'Delete', ['delete', 'id' => $model->id], [
              'class' => $model->isNewRecord ? '' : 'btn btn-danger additionaly-but-del',
              'data' => [
                  'confirm' => 'Are you sure you want to delete this item?',
                  'method' => 'post',
              ],
          ]) ?>
      </div>

</div>
