<?php
use \yii\helpers\Url;
?>

<?php for($i = 0; $i < count($articles); $i++) : ?>

	<?php

		if (empty($articles[$i]['image'])) continue;

		if (strpos($articles[$i]['image'], 'http') !== false) {
			$filename = $articles[$i]['image'];
			$fileurl = $all_articles[$i]['image'];;
		} else {
			$fileurl = Url::to(['/uploads/articles/'.$articles[$i]['image']],true);;
			$filename = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $articles[$i]['image'];
		}

		//TODO:change
		if (empty($filename) || !file_exists($filename)) {
			$filename = $_SERVER['DOCUMENT_ROOT'] . "/web/img/" . 'blank.jpg';
			$fileurl  = Url::to(['/img/'. 'blank.jpg']);
		}


		$size = getimagesize($filename);
		$width =  $size[0];
		$height = $size[1];
		$size = $width . 'x' . $height;

		$pageUrl = Url::base(true) . '/article/' . $articles[$i]['path']; //Url::to(['page/index','id'=>$articles[$i]['id']]);

	?>

	<li class="latest__item" onclick="window.location.href = '<?php echo $pageUrl;?>'">
			<img class="grid-img" size="<?php echo $size; ?>" src="<?php echo  $fileurl;?>">
			<div class="latest__meta">
				<h2 class="latest__meta-title"><?php echo $articles[$i]['title'];?></h2>
				<a class="latest__meta-link" href="<?php echo $pageUrl;?>">Read more</a>
			</div>
	</li>

<?php endfor; ?>
