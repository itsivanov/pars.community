<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Articles */

$this->title = 'Update Articles: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="articles-update">

    <h1><?= Html::encode($this->title) ?></h1>


          <!-- < Загрузчик изображений -->
          <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
          <div class="uploaded-images">
              <div class="content">
                  <!-- Область для перетаскивания -->
                  <div id="drop-files" ondragover="return false">
                    <p>Drag an image here</p>
                        <form id="frm">
                            <input type="file" id="uploadbtn" multiple />
                        </form>
                  </div>
                    <!-- Область предпросмотра -->
                  <div id="uploaded-holder">
                      <div id="dropped-files">
                          <!-- Кнопки загрузить и удалить, а также количество файлов -->
                          <div id="upload-button">
                            <center>
                                <span>0 Files</span>
                                <a href="<?php echo \yii\helpers\Url::to(['/admin/articles/upload-image','id'=>$model->id]);?>" class="upload">Upload</a>
                                <a href="#" class="delete">Delete</a>
                                  <!-- Прогресс бар загрузки -->
                                <div id="loading">
                                    <div id="loading-bar">
                                        <div class="loading-color"></div>
                                    </div>
                                    <div id="loading-content"></div>
                                </div>
                            </center>
                          </div>

                          <!-- < Вывод изображений -->
                          <?php foreach($all_images as $item) : ?>
                              <div id="d<?php echo $item['id']; ?>" class="image" style="background: url(/web/uploads/articles/<?php echo $item['name']; ?>); background-size: cover;">
                                  <a href="#" class="drop-btn-img">Delete image</a>
                                  <input class="id-img" type="hidden" value="<?php echo $item['id']; ?>" />
                              </div>
                          <?php endforeach;  ?>
                          <!-- > -->

                      </div>
                  </div>
                  <!-- Список загруженных файлов -->
                  <div id="file-name-holder">
                      <ul id="uploaded-files">
                          <h1>Uploaded files</h1>
                      </ul>
                  </div>
              </div>
          </div>

          <!-- > -->
          <div class="clear-both"></div>


    <!-- Main image -->
        <label class="control-label" for="articles-file">Image</label>
        <?php if($main_image[0]['image'] != '') : ?>
            <img class="admin-main-image" src="/web/uploads/articles/<?php echo $main_image[0]['image']; ?>">
        <?php else : ?>
            No image
        <?php endif; ?>
    <!-- > -->


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


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
