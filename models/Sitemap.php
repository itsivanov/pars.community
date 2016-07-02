<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use app\models\StaticPages;
use app\models\Category;
use app\models\Articles;

class Sitemap {


  public function generateSitemap() {

    $links = $this->generateLinks();
    $this->generateXML($links);

  }


  public function generateXML($links) {
    $path = $this->getFilePath();

    if(file_exists($path)) {
      $handle = fopen ($path, "w+");
      fclose($handle);
    }

    $fp = fopen($path, "w");

    if($fp) {
      //write header;
      fwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>
                    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">');
      foreach ($links as $link) {
        $url = "<url>";
        $url.= "<loc>" . $link['path'] . "</loc>";

        if(!empty($link['image']))
        {
            $text = (!empty($link['title'])) ? $link['title'] : '';

            $url.= "<image:image>";
            $url.= "  <image:loc>" . $link['image'] . "</image:loc>";
            $url.= "  <image:caption>" . $text . "</image:caption>";
            $url.= "</image:image>";
        }

        $url.= "</url>";


        fwrite($fp, $url);

        clearstatcache (TRUE, $path);
        $currentfileSize = filesize($path) / 1024 / 1024;

        if($currentfileSize > 40)
          break;
      }

    }

    fwrite($fp, '</urlset>');
    fclose($fp);
  }


  public function getFilePath() {
      return Yii::$app->basePath . '/sitemap.xml';
  }

  public function generateLinks() {
    $links = [];
    $links[] = [
      'path'  => Url::base(true)
    ];

    $static_pages = $this->getStaticPages();
    $categories   = $this->getCategories();
    $articles     = $this->getArticles();

    $links = array_merge($links, $static_pages, $categories, $articles);

    return $links;
  }

  function utf8_for_xml($string)
  {
      return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
  }

  public function getArticles() {
    $articles = Articles::get(['limit'=>'30000']);
    $links = [];
    $base  =  Url::base(true) . '/article/';
    $imagesFolder = Url::base(true) . '/web/uploads/articles/';

    foreach ($articles['data'] as $article) {
      $links[] = [
        'path'  => $base . $article['path'],
        'image' => $imagesFolder . $article['image'],
        'title' => addslashes( htmlspecialchars( $this->utf8_for_xml($article['title']) ) ),
      ];
    }

    unset($articles);
    return $links;
  }



  public function getCategories() {
    $categories = Category::getAll();
    $links = [];
    $base  =  Url::base(true) . '/category/';

    foreach ($categories as $category) {
      $links[] = [
        'path'  => $base . urlencode($category['category'])
      ];
    }

    unset($categories);
    return $links;
  }



  public function getStaticPages() {
    $pages = StaticPages::getAll();
    $links = [];
    $base  =  Url::base(true) . '/';

    foreach ($pages as $page) {
      $links[] = [
        'path'  => $base . $page['path']
      ];
    }

    unset($pages);
    return $links;
  }

}



?>
