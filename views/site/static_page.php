<?php
  $this->title = $page['title']  . '. ' . Yii::$app->name;

  $this->registerMetaTag([
      'name' => 'description',
      'content' => $page['meta_description'] . '. ' . Yii::$app->name,
  ], 'description');

  $this->registerMetaTag([
      'name' => 'keywords',
      'content' => $page['meta_keyword'] . '. ' . Yii::$app->name,
  ], 'keywords');

?>



<section class="latest">
  <div class="latest__inner">
    <div class="static-page">
      <h2 class="static-title">
        <?= $page['title']; ?>
      </h2>
      <article class="static-text">
        <?= $page['data']; ?>
      </article>
    </div>
  </div>
</section>
