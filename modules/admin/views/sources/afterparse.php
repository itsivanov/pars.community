<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Sources */

$this->title = 'After Parse';
$this->params['breadcrumbs'][] = ['label' => 'Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-create">

	<?php if (empty($count)) :?>
		<h1>Added no articles</h1>
	<?php else: ?>
		<h1>Added <?php echo $count ?> articles</h1>
	<?php endif; ?>

</div>
