<?php
use \yii\helpers\Url;
$theme = $this->theme;

$this->registerJsFile('/js/frontend/resizeRelative.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
if (!empty($item['image'])) {
	$imageUrl = Url::to(['/uploads/articles/'. $item['image']],true);
} else {
	$imageUrl = null;
}

$shortTitle = $item['title'];
if (mb_strlen($item['title']) > 67) {
	$shortTitle = mb_substr($item['title'], 0, 64) . '...';
}

if (!empty($item['description'])) {
	$metaDescription = $item['description'];
} else {
	$metaDescription = $item['title'];
}

if (!empty($item['keyword'])) {
	$keywords = $item['keyword'];
} {
	$keywords = explode(' ', $item['title']);

	$keywords = array_filter($keywords, function($var){
		return (mb_strlen($var) > 5) ? true : false;
	});

	$keywords = implode(' ', $keywords);
}

if (!empty($item['content'])) {
	$ogMetaDescription = $item['content'];
} else {
	$ogMetaDescription = $metaDescription;
}

$this->title = $item['title'] . '. ' . Yii::$app->name;

$this->registerMetaTag([
		'name' => 'keywords',
		'content' => $keywords . ' ' .Yii::$app->name,
], 'keywords');

$this->registerMetaTag([
		'name' => 'description',
		'content' => $metaDescription . '. ' . Yii::$app->name,
], 'description');

/** Social **/

$this->registerMetaTag(['name' => 'og:title','content' => $item['title']], 'og:title');
$this->registerMetaTag(['name' => 'og:type','content' => 'website'], 'og:type');
$this->registerMetaTag(['name' => 'og:site_name','content' => Yii::$app->name], 'og:site_name');
$this->registerMetaTag(['name' => 'og:locale','content' => 'en_US'], 'og:locale');
$this->registerMetaTag(['name' => 'og:type','content' => 'article'], 'og:type');
$this->registerMetaTag(['name' => 'og:description','content' => $ogMetaDescription], 'og:description');
$this->registerMetaTag(['name' => 'og:url','content' => Url::canonical()], 'og:url');
if (!empty($imageUrl)) {
	$this->registerMetaTag(['name' => 'og:image','content' => $imageUrl], 'og:image');
}

// echo ;
?>

	<main class="index_main page-index_main">
	<div class="banner-cont">
			<div class="bannertop">
				<?= (!empty($banners[2])) ? $banners[2][0] : '';  ?>
			</div>

			<div class="bannerleft">
					<?= (!empty($banners[1])) ? $banners[1][0] : '';  ?>
			</div>

			<div class="bannerright">
					<?= (!empty($banners[3])) ? $banners[3][0] : '';  ?>
			</div>
		<!--
        <a href="#"><img src="../../../web/img/bang.jpg" alt="" class="bannertop"></a>
				<a href="#"><img src="../../../web/img/banv.jpg" alt="" class="bannerleft"></a>
    		<a href="#"><img src="../../../web/img/banv.jpg" alt="" class="bannerright"></a>
			-->
    </div>
		<section class="page__wrapper beforeAnimationDone">
			<?php if(!empty($item['title'])) : ?>
			<h1 class="page__title">
				<?php echo $item['title']; ?>
			</h1>
			<?php endif; ?>

			<ul class="page__info">

				<li class="page__info-item">
					<?php for($i = 0; $i < count($categories); $i++) : ?>
						<a class="category_name_for_single" href="<?php echo Url::to(['site/category','category'=>$categories[$i]['category']],true)?>">
						<?php echo $categories[$i]['category']; ?>
						</a>
					<?php endfor; ?>
				</li>

				<li class="page__info-item"><?php echo date('d F Y', $item['create_time']); ?></li>
			</ul>

			<?php if(!empty($item['video'])) : ?>

				<?php if (strpos($item['video'],'<iframe') === false) :?>
				<div class="video_for_posts">
					<video class="" src="<?php echo $item['video']; ?>" type="video/mp4" controls loop=""></video>
				</div>
				<?php else : ?>
				<div class="video_for_posts">
					<?php echo $item['video']; ?>
				</div>
				<?php endif; ?>

			<?php else : ?>

				<?php if(!empty($imageUrl)) : ?>
				<div class="page__img-wrapper">
					<img class="page__img" src="<?php echo $imageUrl;?>" alt="">
				</div>
				<?php endif; ?>

			<?php endif; ?>


			<?php if(!empty($item['content'])) : ?>
  		<div class="page__text">
				<?php echo $item['content']; ?>
  		</div>
			<?php endif; ?>

			<?php if($item['read_full_article'] != '') : ?>
				<a class="page__link" rel="nofollow" target="_blank" href="<?php echo $item['read_full_article'] ; ?>">Read full article</a>
			<?php endif; ?>

			<?php if(!empty($links)) : ?>
  		<div class="page__links">
				<p class="page__links_title">References</p>
				<ul>
					<?php for ($i=0; $i < count($links); $i++) : ?>
						<li><a class="page__links_a" href="<?php echo $links[$i]['name']; ?>" target="_blank"><?php echo $links[$i]['name']; ?></a></li>
					<?php endfor; ?>
				</ul>
			</div>
			<?php endif; ?>

			<ul class="page__social">
				<li class="page__social-item facebook">
					<a class="page__social-link" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(Url::canonical());?>" target="_blank">
						<span class="page__social-item_desc">Share to facebook</span>
						<span class="page__social-item_circle">
							<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								 width="96.124px" height="96.123px" viewBox="0 0 96.124 96.123" style="enable-background:new 0 0 96.124 96.123;"
								 xml:space="preserve">
								<g><path d="M72.089,0.02L59.624,0C45.62,0,36.57,9.285,36.57,23.656v10.907H24.037c-1.083,0-1.96,0.878-1.96,1.961v15.803
										c0,1.083,0.878,1.96,1.96,1.96h12.533v39.876c0,1.083,0.877,1.96,1.96,1.96h16.352c1.083,0,1.96-0.878,1.96-1.96V54.287h14.654
										c1.083,0,1.96-0.877,1.96-1.96l0.006-15.803c0-0.52-0.207-1.018-0.574-1.386c-0.367-0.368-0.867-0.575-1.387-0.575H56.842v-9.246
										c0-4.444,1.059-6.7,6.848-6.7l8.397-0.003c1.082,0,1.959-0.878,1.959-1.96V1.98C74.046,0.899,73.17,0.022,72.089,0.02z"></path>
								</g></svg>
						</span>
					</a>
				</li>

				<li class="page__social-item twitter">
						<a class="page__social-link" href="https://twitter.com/intent/tweet?url=<?php echo urlencode(Url::canonical());?>&amp;text=<?php echo urlencode($shortTitle);?>&amp;" target="_blank">
							<span class="page__social-item_desc">Share to twitter</span>
							<span class="page__social-item_circle">
								<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 width="512.002px" height="512.002px" viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512.002 512.002;"
									 xml:space="preserve">
								<g><path d="M512.002,97.211c-18.84,8.354-39.082,14.001-60.33,16.54c21.686-13,38.342-33.585,46.186-58.115
										c-20.299,12.039-42.777,20.78-66.705,25.49c-19.16-20.415-46.461-33.17-76.674-33.17c-58.011,0-105.042,47.029-105.042,105.039
										c0,8.233,0.929,16.25,2.72,23.939c-87.3-4.382-164.701-46.2-216.509-109.753c-9.042,15.514-14.223,33.558-14.223,52.809
										c0,36.444,18.544,68.596,46.73,87.433c-17.219-0.546-33.416-5.271-47.577-13.139c-0.01,0.438-0.01,0.878-0.01,1.321
										c0,50.894,36.209,93.348,84.261,103c-8.813,2.399-18.094,3.687-27.674,3.687c-6.769,0-13.349-0.66-19.764-1.888
										c13.368,41.73,52.16,72.104,98.126,72.949c-35.95,28.176-81.243,44.967-130.458,44.967c-8.479,0-16.84-0.496-25.058-1.471
										c46.486,29.807,101.701,47.197,161.021,47.197c193.211,0,298.868-160.062,298.868-298.872c0-4.554-0.104-9.084-0.305-13.59
										C480.111,136.775,497.92,118.275,512.002,97.211z"></path>
								</g></svg>
							</span>
						</a>
				</li>

				<li class="page__social-item google">
						<a class="page__social-link" href="https://plus.google.com/share?url=<?php echo urlencode(Url::canonical());?>" target="_blank">
							<span class="page__social-item_desc">Share to google+</span>
							<span class="page__social-item_circle">
								<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 width="96.828px" height="96.827px" viewBox="0 0 96.828 96.827" style="enable-background:new 0 0 96.828 96.827;"
									 xml:space="preserve">
									<g><path d="M62.617,0H39.525c-10.29,0-17.413,2.256-23.824,7.552c-5.042,4.35-8.051,10.672-8.051,16.912
											c0,9.614,7.33,19.831,20.913,19.831c1.306,0,2.752-0.134,4.028-0.253l-0.188,0.457c-0.546,1.308-1.063,2.542-1.063,4.468
											c0,3.75,1.809,6.063,3.558,8.298l0.22,0.283l-0.391,0.027c-5.609,0.384-16.049,1.1-23.675,5.787
											c-9.007,5.355-9.707,13.145-9.707,15.404c0,8.988,8.376,18.06,27.09,18.06c21.76,0,33.146-12.005,33.146-23.863
											c0.002-8.771-5.141-13.101-10.6-17.698l-4.605-3.582c-1.423-1.179-3.195-2.646-3.195-5.364c0-2.672,1.772-4.436,3.336-5.992
											l0.163-0.165c4.973-3.917,10.609-8.358,10.609-17.964c0-9.658-6.035-14.649-8.937-17.048h7.663c0.094,0,0.188-0.026,0.266-0.077
											l6.601-4.15c0.188-0.119,0.276-0.348,0.214-0.562C63.037,0.147,62.839,0,62.617,0z M34.614,91.535
											c-13.264,0-22.176-6.195-22.176-15.416c0-6.021,3.645-10.396,10.824-12.997c5.749-1.935,13.17-2.031,13.244-2.031
											c1.257,0,1.889,0,2.893,0.126c9.281,6.605,13.743,10.073,13.743,16.678C53.141,86.309,46.041,91.535,34.614,91.535z
											 M34.489,40.756c-11.132,0-15.752-14.633-15.752-22.468c0-3.984,0.906-7.042,2.77-9.351c2.023-2.531,5.487-4.166,8.825-4.166
											c10.221,0,15.873,13.738,15.873,23.233c0,1.498,0,6.055-3.148,9.22C40.94,39.337,37.497,40.756,34.489,40.756z"></path>
										<path d="M94.982,45.223H82.814V33.098c0-0.276-0.225-0.5-0.5-0.5H77.08c-0.276,0-0.5,0.224-0.5,0.5v12.125H64.473
											c-0.276,0-0.5,0.224-0.5,0.5v5.304c0,0.275,0.224,0.5,0.5,0.5H76.58V63.73c0,0.275,0.224,0.5,0.5,0.5h5.234
											c0.275,0,0.5-0.225,0.5-0.5V51.525h12.168c0.276,0,0.5-0.223,0.5-0.5v-5.302C95.482,45.446,95.259,45.223,94.982,45.223z"></path>
									</g></svg>
							</span>
						</a>
				</li>
					<li class="page__social-item tumbir">
						<a class="page__social-link" href="https://www.tumblr.com/share?posttype=photo&canonicalUrl=<?php echo urlencode(Url::canonical());?>&content=<?php echo urlencode($imageUrl)?>&caption=<?php echo urlencode($shortTitle)?>" target="_blank">
							<span class="page__social-item_desc">Share to tumblr</span>
							<span class="page__social-item_circle">
								<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								 viewBox="0 0 22.728 22.728" style="enable-background:new 0 0 22.728 22.728;" xml:space="preserve">
									<g><path d="M12.573,4.94V0H9.385c-0.072,0.183-0.11,0.4-0.11,0.622C9.241,0.729,9.203,0.806,9.203,0.915
											c-0.328,1.829-1.28,3.11-2.892,3.807C5.835,4.94,5.397,4.975,4.921,4.94v3.987h2.342c0.039,5.603,0.039,8.493,0.039,8.64
											c0,0.11,0,0.22,0,0.332c0.294,2.449,1.573,3.914,3.843,4.463c0.914,0.257,1.901,0.366,2.892,0.366
											c1.279-0.036,2.525-0.256,3.771-0.659v-4.685c-0.731,0.22-1.395,0.402-1.977,0.583c-1.135,0.333-2.087,0.113-2.857-0.619
											c-0.073-0.11-0.183-0.257-0.221-0.403c-0.106-0.586-0.178-1.206-0.178-1.795V8.928h5.083V4.94H12.573z"></path>
									</g></svg>
							</span>
						</a>
					</li>

					<?php if (!empty($imageUrl)) : ?>
					<li class="page__social-item pinterest">
						<a class="page__social-link" href="https://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(Url::canonical())?>&media=<?php echo urlencode($imageUrl)?>&description=<?php echo urlencode($shortTitle)?>" target="_blank">
							<span class="page__social-item_desc">Share to pinterest</span>
							<span class="page__social-item_circle">
								<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 viewBox="0 0 486.392 486.392" style="enable-background:new 0 0 486.392 486.392;" xml:space="preserve">
											<g><path d="M430.149,135.248C416.865,39.125,321.076-9.818,218.873,1.642
													C138.071,10.701,57.512,76.03,54.168,169.447c-2.037,57.029,14.136,99.801,68.399,111.84
													c23.499-41.586-7.569-50.676-12.433-80.802C90.222,77.367,252.16-6.718,336.975,79.313c58.732,59.583,20.033,242.77-74.57,223.71
													c-90.621-18.179,44.383-164.005-27.937-192.611c-58.793-23.286-90.013,71.135-62.137,118.072
													c-16.355,80.711-51.557,156.709-37.3,257.909c46.207-33.561,61.802-97.734,74.57-164.704
													c23.225,14.136,35.659,28.758,65.268,31.038C384.064,361.207,445.136,243.713,430.149,135.248z"></path>
											</g></svg>
							</span>
						</a>
					</li>
					<?php endif; ?>

					<li class="page__social-item pinboard">
						<a class="page__social-link" href="https://pinboard.in/add?next=same&url=<?php echo urlencode(Url::canonical())?>&description=<?php echo urlencode($ogMetaDescription)?>&title=<?php echo urlencode($shortTitle)?>" target="_blank">
							<span class="page__social-item_desc">Share to pinboard</span>
							<span class="page__social-item_circle">
								<svg class="page__social-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									 width="430.118px" height="430.118px" viewBox="0 0 430.118 430.118" style="enable-background:new 0 0 430.118 430.118;"
									 xml:space="preserve">
								<g><polygon points="261.954,241.518 345.998,152.215 265.165,172.048 135.835,52.944 135.835,0 0,138.958
										61.431,135.654 171.387,271.298 158.461,344.086 239.29,261.385 430.118,430.118"></polygon>
								</g></svg>
							</span>
						</a>
					</li>
				</ul>


				<div class="bannerbottom">
						<?= (!empty($banners[4])) ? $banners[4][0] : '';  ?>
				</div>

    		<h2 class="page__posts-title">Related posts</h2>
    		<ul class="page__posts">

					<?php foreach($related_posts as $item) : ?>

						<?php
						$urlTo = Url::base(true) . '/article/' . $item['path'];//Url::to(['page/index','id'=>$item['id']]);

						if (isset($item['image']) && $item['image'] != '') {
							if (strpos($item['image'], 'http') === false) {
								$url_to_img = Url::to(['/uploads/articles/'. $item['image']]);
								$pathImage  = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $item['image'];
							} else {
								$url_to_img = $item['image'];
								$pathImage  = $item['image'];
							}
						}

						?>

	            <li class="page__posts-item" onclick="location.href = '<?php echo $urlTo;?>'">

	              <?php if(!empty($url_to_img)) : ?>
									<?php
										$size = '150x150';
										if(file_exists($pathImage))
										{
											$size = getimagesize($pathImage);
											$width =  $size[0];
											$height = $size[1];
											$size = $width . 'x' . $height;
										}
									 ?>

	                <img size="<?= $size ?>" class="grid-img" src="<?php echo $url_to_img; ?>" alt=""> <!-- page__posts-img -->
	              <?php endif; ?>

	              <a class="page__posts-link" href="<?php echo $urlTo;?>"><?php echo $item['title'] ?></a>
	              <div class="page__posts-bg"></div>
	            </li>
	        <?php endforeach; ?>

    		</ul>

    	</section>
    	</main>
