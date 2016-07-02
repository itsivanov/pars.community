<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Banners */

$this->title = 'Create Banners';
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div class="selected_cat">
      <div class="row">

        <div class="col-md-6">
          <div class="title">Categories</div>
          <input type="submit" class="select_all" value="Select all" />
          <input type="submit" class="unselect_all" value="Unselect all" />
          <div class="list-items">
          <?php foreach($allCategory as $item) : ?>
              <div class="cat_b">
                  <div class="cat_row"><?= $item['category']; ?> </div>

                  <div class="cat_row2">
                    <input type="checkbox" class="cat_for_banner" value="<?= $item['id']; ?>" />
                  </div>
              </div>
          <?php endforeach; ?>
          </div>
        </div>

        <div class="col-md-6">
          <div class="title">Soursers</div>
          <div>
            <input data-id="sourceChoosen" type="button" class="select-btn" value="Select all" />
            <input data-id="sourceChoosen" type="button" class="deselect-btn" value="Unselect all" />
          </div>

          <div class="list-items">
              <select data-placeholder="Choose a sources" id="sourceChoosen" name="sources" class="chosen-select" multiple>
                <?php foreach($allSources as $item) : ?>
                    <option value="<?= $item['id'] ?>"><?= $item['name']; ?></option>
                <?php endforeach; ?>
              </select>
          </div>
        </div>

      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success', 'onClick' => '$("#update_banner").submit();' ]) ?>
    </div>

</div>
