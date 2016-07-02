<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Sitemap;
use app\modules\admin\models\Banners;
use app\modules\admin\models\sendMail;

class CronController extends Controller
{
    public function actionGenerateSitemap() {
      $sitemap = new Sitemap();
      $sitemap->generateSitemap();
    }


    public function actionGetDueBanners() {
      $dueBannersNumber = (new Banners())->bannersDue();

      if($dueBannersNumber == 0) {
        return false;
      }

      if($dueBannersNumber > 1) {
        $text = "There are " . $dueBannersNumber . " banners which will expire soon";
      } elseif($dueBannersNumber == 1) {
        $text = "There are 1 banner which will expire soon";
      }

      $to = Yii::$app->params['adminEmail'];
      (new sendMail())->send('Banners due', $text, $to);
      return true;
    }

}

?>
