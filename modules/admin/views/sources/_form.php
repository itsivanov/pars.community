<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Sources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sources-form">

    <?php $form = ActiveForm::begin(['id' => 'update_sources']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_url')->textInput(['maxlength' => true, 'class'=>'form-control form-site_url']) ?>

    <!-- <?php echo $form->field($model, 'feed_url')->textInput(['maxlength' => true, 'class'=>'form-control form-feed_url']) ?> -->

    <?= $form->field($model, 'update_status')->dropDownList([
    '1' => 'Active',
    '0' => 'Inactive',
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList([
    '1' => 'Published',
    '0' => 'Unpublished',
    ]); ?>

    <?php if(!$model->isNewRecord) : ?>
      <?= $form->field($model, 'last_update')->widget(\yii\jui\DatePicker::classname(), [
      //'language' => 'ru',
      'dateFormat' => 'dd-MM-yyyy',
      ]) ?>
    <?php else: ?>
      <?= $form->field($model, 'last_update')->hiddenInput()->label(false); ?>
    <?php endif; ?>


    <?php if($model->isNewRecord) : ?>

        <!-- < Categories -->
        <label class="control-label">Categories</label>

        <div class="selected_cat">

        <input type="submit" class="select_all" value="Select all" />
        <input type="submit" class="unselect_all" value="Unselect all" />

        <div class="row categories_list">
        <?php $i=1; foreach($allCategory as $item) : ?>
            <div class="cat_b">
                <div class="cat_row"><?= $item['category']; ?></div>
                <div class="cat_row2">
                    <input type="checkbox" name='category[<?= $i ?>]' class="cat_for_banner" value="<?= $item['id']; ?>" />
                </div>
            </div>
        <?php $i++; endforeach; ?>
        </div>
        </div>
        <!--
      <label class="control-label">Categories</label>
      <div class="reference">
          When the banner is added it will be possible to choose a category
      </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a($model->isNewRecord ? '' : 'Delete', ['delete', 'id' => $model->id], [
            'class' => $model->isNewRecord ? '' : 'btn btn-danger additionaly-but-del',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    -->
    <?php endif; ?>


    <?php ActiveForm::end(); ?>

</div>
