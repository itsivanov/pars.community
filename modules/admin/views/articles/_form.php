<?php

use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php echo $form->field($model, 'file')->label('Image')->fileInput(); ?>

		<?php if(!empty($model->image)) : ?>
			<img class="admin-main-image" src="/web/uploads/articles/<?= $model->image ?>">
		<?php endif; ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'vendor_code')->textInput(['readonly'=>'true']) ?>
    <?= $form->field($model, 'path')->textInput(['readonly'=>'true']) ?>

		<div class="checkbox">
			<label>
				<input type="checkbox" id="generate_auto_path" checked="true"> Generate path automatical
			</label>
		</div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'video')->textarea() ?>
		<?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()); ?>
    <?= $form->field($model, 'status')->dropDownList([
            '1' => 'Enabled',
            '0' => 'Disabled',
          ]); ?>

    <?php
      if($model['create_time'] != null) {
          echo $form->field($model, 'create_time')->textInput();
      } else {
          echo  $form->field($model, 'create_time')->textInput(['value' => time()]);
      }
    ?>

    <?= $form->field($model, 'read_full_article')->textInput(['maxlength' => true]) ?>

    <?php $this->registerJsFile('@web/js/backend/slugCheck.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
		<?php $this->registerJsFile('@web/js/backend/slugCheckArticles.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
