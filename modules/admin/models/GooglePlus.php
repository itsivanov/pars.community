<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ParsingRss;


class GooglePlus extends ParsingRss
{


      /*
      * Google plus
      */
      public static function setGoogleplus($feed, $last_update)
      {
        $url_xml = @file_get_contents($feed);

        if(!$url_xml)
          return false;
        $param = [];
        // Array XML
        $array_channel = self::getXml($url_xml);

          foreach($array_channel['channel']['item'] as $item)
          {
              if(strtotime($item['pubDate']) <= $last_update)
                continue;

              $title = $item['title'];
              $read_full_article = $item['link'];

              $date = $item['pubDate'];
              $date = self::generateRightDate($date);

              $content = $item['description'];

              // Generate array for insert to db
              $image = $video = "";
              $param[] = [$title, $content, $image, $video, $date, $read_full_article, 1];

          }

          return $param;
      }

}
