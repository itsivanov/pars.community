<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contact us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><span class="tab-title">Full name</span></th>
                    <th><span class="tab-title">E-Mail</span></th>
                    <th><span class="tab-title">Web site</span></th>
                    <th><span class="tab-title">Subject</span></th>
                    <th><span class="tab-title">Date</span></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($all_contacts as $item) : ?>

                <?php if($item->new_message == '1') : ?>
                <tr data-key="12" class="new-message">
                <?php else : ?>
                <tr data-key="12">
                <?php endif; ?>

                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->email; ?></td>
                    <td><?php echo $item->site; ?></td>
                    <td><?php echo $item->subject; ?></td>
                    <td><?php echo $item->date_c; ?></td>
                    <td>
                        <a href="/admin/contact-us/view?id=<?php echo $item->id; ?>" title="View" aria-label="View" data-pjax="0">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a href="/admin/contact-us/delete?id=<?php echo $item->id; ?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>
