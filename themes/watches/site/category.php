<?php
use \yii\helpers\Url;

$this->title = $one_category . '. ' . Yii::$app->name;



if (!empty($categoryData['meta_description'])) {
	$metaKeywords = $categoryData['meta_keywords'];
} else {
	$metaKeywords = $one_category;
}

if (!empty($categoryData['meta_description'])) {
	$metaDescription = $categoryData['meta_description'];
} else {
	$metaDescription = $one_category;
}

$this->registerMetaTag([
    'name' => 'description',
    'content' => $metaDescription . '. ' . Yii::$app->name,
], 'description');

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $metaKeywords . ' ' . Yii::$app->name,
], 'keywords');

$theme = $this->theme;
?>


<?php if(count($all_articles) > 0) : ?>

        <section class="latest">
            <div class="latest__inner">
              <!--<a href="#"><img src="../../../web/img/bang.jpg" alt="" class="banercat"></a>-->

							<div class="banercat"><?= (!empty($banner['banner'])) ? $banner['banner'] : ""; ?></div>
	            <h1 class="latest__item-logo "><!-- latest__item -->
	                <span class="name_cat_instead_logo"><?php echo $one_category; ?></span>
	                <!--<a href="#"><img src="../../../web/img/bang.jpg" alt="" class="bannermin"></a>-->
	            </h1>

							<?php if((!empty( $categoryData['text_above_content']))) : ?>
			            <p class="cattext">
											<?php echo $categoryData['text_above_content']; ?>
									</p>
							<?php endif; ?>

              <ul class="latest__list clearfix" id="grid">
									<?php echo $this->render('_content',['articles' => $all_articles]);?>
              </ul>
							<div class="latest__more_box" style="display:none;">
								<?php if ($pages > $page) :?>
									<?php if (!empty($is_search) && $is_search === true) {
										$url = Url::to(['site/link-more','page' => $page+1,'search' => $one_category]);
									} else {
										$url = Url::to(['site/link-more','page' => $page+1,'category' => $one_category]);
									} ?>
								<a href="<?php echo $url;?>" class="latest__more">load more</a>
								<?php endif; ?>
							</div>
            </div>

						<div id="lazyload_preloader">
							<div class="lazyload_preloader__block">
								<img src="<?php echo $theme->getUrl('img/loader.svg');?>" class="lazyload_preloader__img">
							</div>
						</div>

        </section>


<?php else : ?>

		<?php if((!empty( $categoryData['text_above_content']))) : ?>
				<section class="text_above_content">
						<?= (!empty( $categoryData['text_above_content'])) ? $categoryData['text_above_content'] : '';  ?>
				</section>
		<?php endif; ?>

    <section class="no-articles">
         There are no articles in this category.
    </section>
<?php endif; ?>
