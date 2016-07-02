<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\Articles;
?>


<?php
$url = Url::home(true);

AppAsset::register($this);
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

      <?= $content ?>


      <!-- < Pop-up contact us -->
          <!--modal window (.contact-wrapper -> display:none)-->
          <div class="contact-wrapper">
          <!--form for send message(.contacts -> display:none)-->
          <div class="contact-inner contacts">
            <svg class="contact-close" viewBox="0 0 17 21" >
              <path class="st0" d="M16.5,16.9l-1.6,1.6l-6.4-6.4l-6.4,6.4l-1.6-1.6l6.4-6.4L0.5,4.1l1.6-1.6l6.4,6.4l6.4-6.4l1.6,1.6l-6.4,6.4
              L16.5,16.9z"/>
            </svg>
            <form novalidate id="contact-form" method="post" class="contact__form">
              <div class="contact__form_group">
                <input type="text" class="contact__form_input send_full_name" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="contact__form_label">Full name</label>
              </div>
              <div class="contact__form_group">
                <input type="text" class="contact__form_input send_e_mail" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="contact__form_label">E-Mail</label>
              </div>
              <div class="contact__form_group">
                <input type="text" class="contact__form_input send_web_site" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="contact__form_label">Web site</label>
              </div>
              <div class="contact__form_group">
                <input type="text" class="contact__form_input send_subject" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="contact__form_label">Subject</label>
              </div>
              <div class="contact__form_group">
                <textarea rows="3" class="contact__form_input send_message" required></textarea>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="contact__form_label">Your Message</label>
              </div>

              <button type="submit" class="contact__send">Send Message</button>
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
      <!-- > -->

      <!-- < search block (.search-block -> display:none)-->
          <div class="search-block">
          <svg class="search-close" viewBox="0 0 17 21" >
            <path class="st0" d="M16.5,16.9l-1.6,1.6l-6.4-6.4l-6.4,6.4l-1.6-1.6l6.4-6.4L0.5,4.1l1.6-1.6l6.4,6.4l6.4-6.4l1.6,1.6l-6.4,6.4
            L16.5,16.9z"/>
          </svg>
          <div class="search-box">
            <input class="search-input" placeholder="Summer 2015-2016">
            <button class="search-btn"></button>
          </div>
          </div>
      <!--  > -->

      <!-- < menu block (.menu-open -> display:none)-->
          <div class="menu">
          <svg class="icon-close" viewBox="0 0 17 21" >
            <path class="st0" d="M16.5,16.9l-1.6,1.6l-6.4-6.4l-6.4,6.4l-1.6-1.6l6.4-6.4L0.5,4.1l1.6-1.6l6.4,6.4l6.4-6.4l1.6,1.6l-6.4,6.4
              L16.5,16.9z"/>
          </svg>
          <div class="menu__inner">
            <div class="menu__super_inner">

            <ul class="menu__list">
              <li class="menu__item"><button type="button" class="menu__button">Home</button></li>
              <li class="menu__item click__brands"><button type="button" class="menu__button">Brand Update</button></li>
              <li>
                <ul class="menu__brands">
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                  <li class="menu__brands-item">Chi Chi</li>
                </ul>
              </li>
              <li class="menu__item"><button type="button" class="menu__button">Fashion</button></li>
              <li class="menu__item"><button type="button" class="menu__button">Beauty</button></li>
              <li class="menu__item"><button type="button" class="menu__button">Vloggers</button></li>
              <li class="menu__item"><button type="button" class="menu__button">Insta Bloggers</button></li>
              <li class="menu__item"><button type="button" class="menu__button">Fashion Week</button></li>

            </ul>
            </div>
          </div>
          <footer class="menu__footer">
            <button type="button" class="menu__button menu__item menu__contact">Contact Us</button>
            <p class="menu__copyright">© hsd.com 2007-2016</p>
          </footer>
          </div>
      <!-- > -->


      <?php
      /* <div class="wrap">
          <?php
          NavBar::begin([
              'brandLabel' => 'Template',
              'brandUrl' => Yii::$app->homeUrl,
              'options' => [
                  'class' => 'navbar-inverse navbar-fixed-top',
              ],
          ]);
          echo Nav::widget([
              'options' => ['class' => 'navbar-nav navbar-right'],
              'items' => [
                  ['label' => 'Home', 'url' => ['/']],
              ],
          ]);
          NavBar::end();
          ?>

          <div class="container">
              <?= Breadcrumbs::widget([
                  'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
              ]) ?>
              <?= $content ?>
          </div>
      </div>

      <footer class="footer">
          <div class="container">
              <p class="pull-left">&copy; Template <?= date('Y') ?></p>

              <p class="pull-right"><?php echo Yii::powered() ?></p>
          </div>
      </footer>
      */ ?>

      <?php $this->endBody() ?>

      <script type="text/javascript">
    		$(document).ready(function() {
    			$('#contact-form').on('submit.contactform',function(){

    				$('.contact-inner.contacts').fadeOut(300);
    				$('.contact-inner.thanks').fadeIn(300);

    				setTimeout(function () {
    					(new Menus()).move('contactClose',function(){
    						$('.contact-inner.contacts').show();
    						$('.contact-inner.thanks').hide();
    					});
    				}, 3000);

    				return false;
    			});
    		})
  		</script>

      <?php if($_SERVER['REQUEST_URI'] == '/') : ?>
          <script src="/web/js/frontend/scroller.js"></script>
      <?php endif; ?>

  </body>
</html>
<?php $this->endPage() ?>
