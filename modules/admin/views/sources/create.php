<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Sources */

$this->title = 'Create Sources';
$this->params['breadcrumbs'][] = ['label' => 'Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allCategory' => $allCategory,
    ]) ?>



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
