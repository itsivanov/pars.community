<?php
use \yii\helpers\Url;
use app\models\Page;

Page::getSettings();
$theme = $this->theme;

$params = Yii::$app->params;

Yii::$app->name = (!empty($params['name'])) ? $params['name'] : '';
$description = (!empty($params['description'])) ? Yii::$app->name . ' ' .  $params['description'] : Yii::$app->name;
$keywords = (!empty($params['keywords'])) ? Yii::$app->name . ' ' . $params['keywords'] : Yii::$app->name;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $description,
], 'description');

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords,
], 'keywords');
?>


 <div class="popular_gradient"></div>
 <div class="popular_net">
	 <div class="net__top"></div>
	 <div class="net__l1_left"></div>
	 <div class="net__l2_left"></div>
	 <div class="net__l3_left"></div>

	 <div class="net__l1"></div>
	 <div class="net__l2"></div>
	 <div class="net__l3"></div>
	 <div class="net__bottom"></div>

 </div>

    	<section class="popular">
    		<h1 class="popular__logo"><img class="popular__logo-img" alt="popular posts" src="<?php echo $theme->getUrl('img/title_popular.svg');?>"></h1>
    		<ul class="popular__list clearfix">

					<?php foreach ($all_articles as $i => $value) : ?>

			      <?php
			        // Size image
			        if ($all_articles[$i]['image'] != '') {
			            if(strpos($all_articles[$i]['image'], 'http') !== false) {
										$fileurl  = $all_articles[$i]['image'];
										$filename = $all_articles[$i]['image'];
									} else {
										$filename = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $all_articles[$i]['image'];
										$fileurl  = Url::to(['/uploads/articles/'. $all_articles[$i]['image']]);
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

			        }

							$urlTo = Url::base(true) . '/article/' . $all_articles[$i]['path']; //Url::to(['page/index','id'=>$all_articles[$i]['id']]);

							$all_articles[$i]['hover_color'] = (empty($all_articles[$i]['hover_color'])) ? 'rgba(210, 119, 158, 0.9)' : $all_articles[$i]['hover_color'];

              if($i == 6)
                break;

			      ?>

    			<li class="popular__item">

    				<a class="popular__link" href="<?php echo $urlTo;?>">

							<?php if($all_articles[$i]['image'] != '') : ?>
								<img class="popular__img" size="<?php echo $size; ?>"
								src="<?php echo $fileurl; ?>" alt="<?php echo $all_articles[$i]['title'] ?>">
	            <?php endif; ?>

    				</a>
    			</li>

				<?php endforeach; ?>

    		</ul>
    	</section>
        <section class="latest">
            <div class="latest__inner">
            <h1 class="latest__item-logo latest__item">
							<img class="latest__logo-img" alt="watchindemand" src="<?php echo $theme->getUrl('img/title_latest.svg');?>">
						</h1>
                <ul class="latest__list clearfix" id="grid">


										<?php
										unset($all_articles[0]);
										unset($all_articles[1]);
										unset($all_articles[2]);
										unset($all_articles[3]);
										unset($all_articles[4]);
										unset($all_articles[5]);

										$all_articles = array_values($all_articles);
										?>

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
