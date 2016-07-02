<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Banners */

$this->title = 'Update Banners: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="banners-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <input type="hidden" class="id_m" value="<?php echo $model->id; ?>" />


    <!-- < Categories -->
          <label class="control-label">Categories</label>

          <!-- < Array checked categories -->
          <?php
          $ckeckedItem = [];
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

        <div class="row">

          <div class="col-md-6">

            <input type="submit" class="select_all" value="Select all" />
            <input type="submit" class="unselect_all" value="Unselect all" />
            <div class="list-items">
            <?php foreach($allCategory as $item) : ?>
                <div class="cat_b">
                    <div class="cat_row"><?php echo $item['category']; ?> </div>

                      <?php if(in_array($item['id'], $ckeckedItem)) : ?>
                        <div class="cat_row2">
                          <input type="checkbox" class="cat_for_banner" value="<?php echo $item['id']; ?>" checked="checked" />
                        </div>
                      <?php else : ?>
                        <div class="cat_row2">
                          <input type="checkbox" class="cat_for_banner" value="<?php echo $item['id']; ?>" />
                        </div>
                      <?php endif; ?>

                </div>
            <?php endforeach; ?>
            </div>

          </div>
          <div class="col-md-6">
            <div>
              <input data-id="sourceChoosen" type="button" class="select-btn" value="Select all" />
              <input data-id="sourceChoosen" type="button" class="deselect-btn" value="Unselect all" />
            </div>

            <div class="list-items">
                <SELECT data-placeholder="Choose a sources" id="sourceChoosen" name="sources" class="chosen-select" multiple>
                  <?php foreach($allSources as $item) : ?>
                      <?php if(in_array($item['id'], $checkedSources)) : ?>
                          <option value="<?= $item['id'] ?>" selected="true"><?= $item['name']; ?></option>
                      <?php else : ?>
                          <option value="<?= $item['id'] ?>"><?= $item['name']; ?></option>
                      <?php endif; ?>
                  <?php endforeach; ?>
                </SELECT>
            </div>



          </div>

        </div>

      </div>


      <div class="form-group">
          <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'onClick' => '$("#update_banner").submit();' ]) ?>
          <?= Html::a($model->isNewRecord ? '' : 'Delete', ['delete', 'id' => $model->id], [
              'class' => $model->isNewRecord ? '' : 'btn btn-danger additionaly-but-del',
              'data' => [
                  'confirm' => 'Are you sure you want to delete this item?',
                  'method' => 'post',
              ],
          ]) ?>
      </div>

</div>
