<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Banners;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Banners */
/* @var $form yii\widgets\ActiveForm */


  $this->registerJs("
    var old_date = $('#banners-due_date').val();

    $('#expire_change').on('click', function(){
      $('.change_banners_due').toggle();
    });

    $('#from_today, .day_month').on('focus', function() {
      $('.active').removeClass('active');
      $('.expirefrom_today').addClass('active');
    });

    $('#banners-due_date').on('focus', function() {
      $('.active').removeClass('active');
      $('.expirefrom_due_date').addClass('active');
    });

    $('#close_due_date_block').on('click', function(){
      $('.change_banners_due').hide();
      $('#banners-due_date').val(old_date);
      $('.expire_date').text(old_date);
    });

    $('#from_today, .day_month').on('focus keyup blur change', function() {
      var type = $('.day_month').val();
      var date = new Date();

      if(type == 'days') {
        var days = parseInt($('#from_today').val());
        if(days > 0) {
          date.setDate(date.getDate() + days);
        } else {
          date.setDate(date.getDate() + 30);
        }
      } else if(type == 'months') {
        var months = parseInt($('#from_today').val());
        if(months > 0) {
          date = new Date(date.setMonth(date.getMonth() + months));
        } else {
          date.setDate(date.getDate() + 30);
        }
      }

      var day  = date.getDate();
      var month  = date.getMonth() + 1;
      if(day < 10)
        day = '0' + day;

      if(month < 10)
        month = '0' + month;

      $('#banners-due_date').val(day + '-' + month + '-' + date.getUTCFullYear());
      $('.expire_date').text(day + '-' + month + '-' + date.getUTCFullYear());
    });


    $('.cat_for_banner').on('change', function(){
      var data = [];
      $('.cat_for_banner').each(function(){
        if($(this).prop('checked'))
          data[data.length] = $(this).val();
      });
      $('#banners-categories').val(data.join(','));
    });

    $('#sourceChoosen').on('change', function(){
      $('#banners-sources').val($('#sourceChoosen').val().join(','))
    });

    $('#banners-nummer_block, #banners-status, .day_month').selectric();

  ", View::POS_END, 'due_date');

$model->create_date = time();
?>

<div class="banners-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'update_banner']); ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'create_date')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'categories')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'sources')->hiddenInput()->label(false); ?>


    <?= $form->field($model, 'banner')->textarea(['rows' => '18']); ?>
    <?= $form->field($model, 'nummer_block')->dropDownList(Banners::$blocks_name); ?>
    <?= $form->field($model, 'status')->dropDownList([1 => 'Enable', 0 => 'Disable']); ?>


    <div class="expire__block__wrap">
      <div class="expire__text">
        Banner will expire:
        <span class="expire_date"><?= date('d-m-Y', $model->due_date) ?></span>
        <span id="expire_change">(change)</span>
      </div>

      <div class="change_banners_due">
        <div class="expire__block expirefrom_today">

            <label for="from_today">From today: </label>
            <input id="from_today" type='test' name="from_today" />

            <div class="select_day_month">
              <select class="day_month">
                <option value="days">Days</option>
                <option value="months">Months</option>
              </select>
            </div>
            
        </div>
        <div class="text-center">
          OR
        </div>
        <div class="expire__block expirefrom_due_date">
            <?= $form->field($model, 'due_date')->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'dd-MM-yyyy',
                'options' => ['class' => 'due_date_datepicker']])
                ->label('Due date: '); ?>
        </div>

        <div id="close_due_date_block" class="btn btn-danger">
          Cancel changing
        </div>
      </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
