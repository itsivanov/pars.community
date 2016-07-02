<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\WatchesAsset;
use yii\helpers\Url;
use app\models\Articles;
use app\models\StaticPages;
use app\models\Page;
?>
<?php

Page::getSettings();

$url = str_replace("//", "/", Url::home(true));

if(!empty(Yii::$app->params['name']))
  Yii::$app->name = Yii::$app->params['name'];

$staticPages = StaticPages::getAll();

WatchesAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
      <meta charset="<?= Yii::$app->charset ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

      <?= Html::csrfMetaTags() ?>

      <?php $this->head() ?>

			<title><?= Html::encode((empty($this->title)) ? Yii::$app->name : $this->title) ?></title>

      <script type="text/javascript">
          var Host     = '<?php echo $url; ?>';
					var HOST     = '<?php echo Url::to(['/'],true); ?>';
          var CATEGORY = '<?php echo Yii::$app->request->get('category'); ?>';
          var SEARCH   = '<?php echo Yii::$app->request->get('search_req'); ?>';
          var PAGE     = '<?php echo Yii::$app->request->get('page',1); ?>';
      </script>
  </head>
  <body>
  <?php $this->beginBody() ?>
<div class="header-top">
<div class="linkL">
  <?php for($i = 0; $i < (count($staticPages) / 2);  $i++): ?>
     <a href="/<?= $staticPages[$i]['path']; ?>" class="static-pages-link"><?= $staticPages[$i]['title'] ?></a>
  <?php endfor; ?>
</div>
<div class="img-conteiner">
  <a class="logo-url" href="<?= $url ?>" ><img src="/img/logo-white-header.jpg" alt=""></a>
</div>
<div class="linkR">
  <?php for($i = ceil(count($staticPages) / 2); $i < count($staticPages);  $i++): ?>
     <a href="/<?= $staticPages[$i]['path']; ?>" class="static-pages-link"><?= $staticPages[$i]['title'] ?></a>
  <?php endfor; ?>
</div>
</div>
	<div class="menu__visible">
				<!-- <svg class="btn-search" viewBox="0 0 17 21" style="enable-background:new 0 0 17 21;" xml:space="preserve">
						<path class="st0" d="M11.4,12.7h0.8l4.9,4.9L15.5,19l-4.9-4.9v-0.8l-0.3-0.3c-1.1,1-2.5,1.6-4.1,1.6C2.8,14.6,0,11.8,0,8.3
								C0,4.8,2.8,2,6.3,2c3.5,0,6.3,2.8,6.3,6.3c0,1.6-0.6,3-1.6,4.1L11.4,12.7z M6.3,3.9c-2.4,0-4.4,1.9-4.4,4.4s1.9,4.4,4.4,4.4
								c2.4,0,4.4-1.9,4.4-4.4S8.7,3.9,6.3,3.9z"/>
				</svg> -->
				<svg   class="btn-search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve">
						<path class="st0" d="M15.5,15.1l-4.7-4.7c1-1.1,1.7-2.5,1.7-4.1c0-3.3-2.7-6-6-6s-6,2.7-6,6s2.7,6,6,6c1.3,0,2.6-0.4,3.6-1.2
						l4.8,4.8L15.5,15.1z M6.5,11.2c-2.8,0-5-2.2-5-5s2.2-5,5-5s5,2.2,5,5S9.2,11.2,6.5,11.2z"/>
				</svg>

				<img src="/img/logo-black-header.svg" alt="" class="text-header head-main">

				<div class="menu__btn">
						<span class="menu__btn-stripe"></span>
						<span class="menu__btn-stripe"></span>
						<span class="menu__btn-stripe"></span>
				</div>
				<div class="copyright-wrapper">
						<div class="copyright">&copy;&nbsp;<?php echo $_SERVER['HTTP_HOST'];?> 2007-2016</div>
				</div>
		</div>
<img src="../../../web/img/interface.svg" alt="" class="nav-min">
    	<div class="mini-menu-h head-main">
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
        <a href="#">Link 4</a>
            </div>
		<div class="menu clearfix">
            <div class="menu__inner">
                <svg class="close-btn" viewBox="0 0 17 21" style="enable-background:new 0 0 17 21;" xml:space="preserve">
                    <path class="st0" d="M16.5,16.9l-1.6,1.6l-6.4-6.4l-6.4,6.4l-1.6-1.6l6.4-6.4L0.5,4.1l1.6-1.6l6.4,6.4l6.4-6.4l1.6,1.6l-6.4,6.4
                    L16.5,16.9z"/>
                </svg>
                <div class="wrapper-search">
									<form id="search-form" action="/" method="post">
										<input class="search-input" placeholder="Search">
									</form>

                </div>
                <div class="menu__wrapper">
		  <?php $all_categories = Articles::getMainCategories(); ?>
								<?php $currentCategory = Yii::$app->request->get('category',false);?>

                <ul class="menu__list">
                    <li class="menu-item click__brands">
                        <a class="main-item <?php echo ($currentCategory == false) ? 'active-item' : '';?>" href="/">Home</a>
                    </li>

                  <!-- Main categories -->
                  <?php foreach($all_categories as $item) : ?>


                  <?php
                  $parent_id = $item['id'];
                  $parens_cat = Articles::getPanrentCategories($parent_id);
                  ?>

                  <li class="menu-item click__brands">
                      <?php if(!empty($parens_cat)) : ?>

                            <!--<button type="button" class="menu__button"><?php echo $item['category']; ?></button>-->
                            <a class="main-item parent_cat <?php echo ($currentCategory == $item['category']) ? 'active-item' : '';?>" href="<?php echo Url::to(['site/category','category'=>$item['category']],true)?>">
                                <?php echo $item['category']; ?>
                            </a>

                            <ul class="menu__brands">

                              <!-- Parents categories -->
                              <?php
                                 foreach ($parens_cat as $parents) : ?>
                                      <?php if($parents['parent_id'] == $parent_id) : ?>

                                        <li class="menu__brands-item">
                                            <a class="<?php echo ($currentCategory == $parents['category']) ? 'active-item' : '' ; ?>" href="<?php echo Url::to(['site/category','category'=>$parents['category']],true)?>">
                                                <span><?php echo $parents['category']; ?></span>
                                            </a>
                                        </li>

                                      <?php endif; ?>
                             <?php endforeach; ?>

                            </ul>



                      <?php else : ?>
                        <a class="main-item menu__button <?php echo ($currentCategory == $item['category']) ? 'active-item' : '';?>" href="<?php echo Url::to(['site/category','category'=>$item['category']],true)?>">
                            <?php echo $item['category']; ?>
                        </a>
                      <?php endif; ?>
                  </li>

                  <?php endforeach; ?>

                </ul>
		<!--
                    <ul class="menu__list">

                      <?php
                        $parens_cat = Articles::getMainCategories();
			$currentCategory = Yii::$app->request->get('category',false);

                         foreach ($parens_cat as $parents) : ?>
												 	<?php //if ($parents['articles'] <= 0) continue;?>
                          <?php //echo Url::to(['site/category','category'=>$parents['category']],true) ?>
                                <li class="menu-item">
                                    <a class="<?php echo ($currentCategory == $parents['category']) ? 'active' : '' ; ?>" href="<?= Url::base(true) . '/category/' . $parents['category']; ?>">
                                        <?php echo $parents['category']; ?>
                                    </a>
                                </li>

                     <?php endforeach; ?>

                    </ul>-->
                </div>

            </div>

    	</div>

      <?= $content ?>


			<!--modal window (.contact-wrapper -> display:none)-->
			<div class="contact-wrapper">
			<!--form for send message(.contacts -> display:none)-->
					<div class="contact-inner contacts">
							<svg class="contact-close" viewBox="0 0 17 21" >
									<path class="st0" d="M16.5,16.9l-1.6,1.6l-6.4-6.4l-6.4,6.4l-1.6-1.6l6.4-6.4L0.5,4.1l1.6-1.6l6.4,6.4l6.4-6.4l1.6,1.6l-6.4,6.4
									L16.5,16.9z"/>
							</svg>
							<form novalidate id="contact-form" action="/" method="post" class="contact__form">
									<div class="contact__form_group">
											<input type="text" class="contact__form_input" required>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label class="contact__form_label">Full name</label>
									</div>
									<div class="contact__form_group">
											<input type="text" class="contact__form_input" required>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label class="contact__form_label">E-Mail</label>
									</div>
									<div class="contact__form_group">
											<input type="text" class="contact__form_input" required>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label class="contact__form_label">Web site</label>
									</div>
									<div class="contact__form_group">
											<input type="text" class="contact__form_input" required>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label class="contact__form_label">Subject</label>
									</div>
									<div class="contact__form_group">
											<textarea rows="3" class="contact__form_input" required></textarea>
											<span class="highlight"></span>
											<span class="bar"></span>
											<label class="contact__form_label">Your Message</label>
									</div>

									<button type="submit" class="contact__send  mCustomScrollbar _mCS_1">Send Message</button>
							</form>
					</div>
					<!--thanks block (.thanks -> display:none)-->
					<div class="contact-inner thanks">
							<div class="thanks__icon">
									<svg class="thanks__mark" viewBox="0 0 19.5 14.2">
											<path class="st0" d="M6.2,14.2l-6-5.9l1.5-1.5l4.5,4.4L17.7,0.2l1.5,1.5L6.2,14.2z"/>
									</svg>
							</div>
							<div class="thanks__desctription">
									<span class="thanks__title">Thank you a lot!</span><br>
									<span class="thanks__text">we'll answer you as quick as possible</span>
							</div>

					</div>
			</div>


			<footer class="mobile__footer">
					<p class="mobile__footer-copyright">&copy;&nbsp;<?php echo $_SERVER['HTTP_HOST'];?> 2007-2016</p>
			</footer>

			<?php if($_SERVER['REQUEST_URI'] == '/') : ?>
          <!-- <script src="/web/js/frontend/scroller.js"></script> -->
      <?php endif; ?>

			<?php $this->endBody() ?>

  </body>
</html>
<?php $this->endPage() ?>
