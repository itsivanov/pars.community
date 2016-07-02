<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'keywords')->textarea() ?>
        <?= $form->field($model, 'google_analitics') ?>
        <?= $form->field($model, 'db_host') ?>
        <?= $form->field($model, 'db_name') ?>
        <?= $form->field($model, 'db_user') ?>
        <?= $form->field($model, 'db_password') ?>

				<?= $form->field($model, 'facebook_app_id') ?>
				<?= $form->field($model, 'facebook_app_secret') ?>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>

</div>
