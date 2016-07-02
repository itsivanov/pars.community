<?php
use \yii\helpers\Url;

$theme = $this->theme;

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->name,
], 'description');

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::$app->name,
], 'keywords');
?>


        <section class="latest">
            <div class="latest__inner">
            <h1 class="latest__item-logo latest__item"><img class="latest__logo-img" alt="watchindemand" src="<?php echo $theme->getUrl('img/title_latest.svg');?>"></h1>
                <ul class="latest__list clearfix" id="grid">
										<?php echo $this->render('_content',['articles' => $all_articles]);?>
                </ul>

								<div class="latest__more_box" style="display:none;">
									<?php if ($pages > $page) :?>
									<a href="<?php echo Url::to(['site/link-more','page'=>$page+1]);?>" class="latest__more">load more</a>
									<?php endif; ?>
								</div>
            </div>

						<div id="lazyload_preloader">
							<div class="lazyload_preloader__block">
								<img src="<?php echo $theme->getUrl('img/loader.svg');?>" class="lazyload_preloader__img">
							</div>
						</div>

        </section>
