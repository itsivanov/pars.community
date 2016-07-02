<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Articles */

$this->title = 'Create Articles';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="articles-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <input type="hidden" name="id-for-link" class="id-for-link" value="<?php echo time(); ?>">

        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
        ]) ?>

        <div class="row categories_list">
        <?php foreach($categories as $item) : ?>
            <div class="cat_b">
                <div class="cat_row"><?php echo $item['category']; ?></div>
                <div class="cat_row2">
                    <input type="checkbox" class="art_cat_for_banner" value="<?php echo $item['id']; ?>" />
                </div>
            </div>
        <?php endforeach; ?>
        </div>


          <h1>Links</h1>
          <div class="reference">
          <form method="post" id="form-links">
              <table id="table_container">
                      There is no reference
                </table>
                <input type="button" value="+" id="add" class="plus" onclick="return add_new_image();">

                <!--
                <div class="form-group but-bnt">
                    <?= Html::submitButton('Create', ['class' =>  'btn btn-primary add-link-ajax' ]) ?>
                </div>
                -->

            </form>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary add-link-ajax']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>


</div>
