<?php

use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

    <?= $form->field($model, 'id')->label(false)->hiddenInput(); ?>
    <?= $form->field($model, 'title')->textInput(); ?>
    <?= $form->field($model, 'meta_keyword')->textInput(); ?>
    <?= $form->field($model, 'meta_description')->textInput(); ?>
    <?= $form->field($model, 'update_date')->label(false)->hiddenInput(); ?>
    <?= $form->field($model, 'path')->textInput(['readonly'=>'true']); ?>

    <div class="checkbox">
      <label>
        <input type="checkbox" id="generate_auto_path" checked="true"> Generate path automatical
      </label>
    </div>


    <?= $form->field($model, 'data')->widget(\yii\redactor\widgets\Redactor::className()); //->widget(\yii\redactor\widgets\Redactor::className()); ?>

    <?php $this->registerJsFile('@web/js/backend/slugCheck.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
		<?php $this->registerJsFile('@web/js/backend/slugCheckStaticPages.js',['depends' => [\app\assets\AdminAsset::className()]]); ?>
