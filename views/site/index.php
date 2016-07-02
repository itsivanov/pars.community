<?php
use \yii\helpers\Url;
 ?>
<!-- <header> -->
  <!-- <div class="btn-menu-open"><img src="img/menu_black.svg"></div>
  <div class="btn-search-open"><img src="img/search_black.svg"></div> -->
<!-- </header> -->


<main class="index_main">

<div class="logo"><img src="/web/img/HSD-logo.svg"></div>

<section id="first_screen" class="beforeAnimationDone">

  <div id="popular_grid" >
  <h1 id="h1__pp"><span id="pp_1">popular</span> <span  id="pp_2">posts</span></h1>
  <ul >

    <?php for($i = 0; $i < 6; $i++) : ?>

      <?php

        // Size image
        if($all_articles[$i]['image'] != '')
        {
            if(strpos($all_articles[$i]['image'], 'http') !== false)
              $filename = $all_articles[$i]['image'];
            else
              $filename = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $all_articles[$i]['image'];

            $size = getimagesize($filename);
            $width =  $size[0];
            $height = $size[1];
            $size = $width . 'x' . $height;
        }
      ?>

    <li class="popular_grid__li ">
        <p class="popular_grid_image_slice">
            <div class="photo_bg"></div>

            <?php if($all_articles[$i]['image'] != '') : ?>
                <?php if(strpos($all_articles[$i]['image'], 'http') !== false): ?>
                 <img class="popular_grid__img" size="<?php echo $size; ?>"
                 src="<?php echo $all_articles[$i]['image']; ?>"
                 alt="celebrity street style paris" background="<?php echo (isset($all_articles[$i]['background'])) ? $all_articles[$i]['background'] : ''; ?>">
                <?php else: ?>
                 <img class="popular_grid__img" size="<?php echo $size; ?>"
                 src="/web/uploads/articles/<?php echo $all_articles[$i]['image']; ?>"
                 alt="celebrity street style paris" background="<?php echo (isset($all_articles[$i]['background'])) ? $all_articles[$i]['background'] : ''; ?>">
               <?php endif; ?>
            <?php endif; ?>

            <?php //Url::to(['page/index','id'=>$all_articles[$i]['id']],true) ?>
            <a href="<?= Url::base(true) . '/articles/' . $all_articles[$i]['path']; ?>" class="popular_grid__meta">celebrity street style paris</a>

            <div class="popular_grid__svg">
              <svg class="meta__arrow" viewBox="0 0 17 21">
                  <path class="st0" d="M11,16l-1-1l3.8-3.8H0.5V9.8h13.4L10,6l1-1l5.5,5.5L11,16z"/>
              </svg>
            </div>
        </p>
    </li>

    <?php endfor; ?>

  </ul>
</div>
</section>

<section id="section_content">
<div class="logo"><img src="/web/img/HSD-logo.svg"></div>
  <div class="latest">
    <p class="latest-title">latest posts</p>
    <ul class="grid" id="grid">

      <?php for($i = 6; $i < count($all_articles); $i++) : ?>

        <?php
          // Size image
          if($all_articles[$i]['image'] != '')
          {
              if(strpos($all_articles[$i]['image'], 'http') !== false)
                $filename = $all_articles[$i]['image'];
              else
                $filename = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/articles/" . $all_articles[$i]['image'];

              $size = getimagesize($filename);
              $width =  $size[0];
              $height = $size[1];
              $size = $width . 'x' . $height;
          }
        ?>

      <li class="grid-item">
        <a href="#">

          <?php if($all_articles[$i]['image'] != '') : ?>
            <?php if(strpos($all_articles[$i]['image'], 'http') !== false) : ?>
              <img class="grid-img" size="<?php echo $size; ?>" src="<?php echo $all_articles[$i]['image']; ?>"
            <?php else: ?>
              <img class="grid-img" size="<?php echo $size; ?>" src="/web/uploads/articles/<?php echo $all_articles[$i]['image']; ?>"
            <?php endif; ?>
              background="<?php echo (isset($all_articles[$i]['background'])) ? $all_articles[$i]['background'] : ''; ?>">
          <?php endif; ?>

        </a>
        <div class="item-desctription">
          <div class="desctription-inner">
            <?php //echo Url::to(['page/index','id'=>$all_articles[$i]['id']],true)?>
            <a href="<?= Url::base(true) . '/articles/' . $all_articles[$i]['path']; ?>" class="item-text">london studio presentation</a>
            <span class="item-category">Presentation</span>
          </div>
          <svg class="meta__arrow" viewBox="0 0 17 21">
          <path class="st0" d="M11,16l-1-1l3.8-3.8H0.5V9.8h13.4L10,6l1-1l5.5,5.5L11,16z"/>
        </svg>
        </div>
      </li>

      <?php endfor; ?>

    </ul>
    <img src="/web/uploads/others/loader.svg" id="imgPreload">
    <!-- <button class="latest__more">load more</button> -->
  </div>
</section>



</main>


<div class="copyright-wrapper"><div class="copyright">&copy; hsd.com 2007-2016</div></div>
<div class="contact__wrapper"><div class="contact">contact us</div></div>


<!-- < Было изначально (mail) -->

    <?php

    /* @var $this yii\web\View */

    // $this->title = 'Yii2 Template';
    ?>
    <!-- <div class="site-index">
        <?php //echo $this->render('_form'); ?>
    </div> -->

<!-- > -->


<div id="content">
</div>
