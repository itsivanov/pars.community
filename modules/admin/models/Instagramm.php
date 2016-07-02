<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ParsingRss;
use app\modules\admin\models\Articles;

class Instagramm extends ParsingRss
{

      /*
      * Directly from the site Instagram
      */
      public static function directlyFromInstagram($feed, $last_update)
      {
					\Yii::trace('begin Instagramm:'.$feed, 'parsing');

            $html = @file_get_contents($feed);

            if(!$html) {
							\Yii::trace('file_get_contents dont return any', 'parsing');
							return false;
						}

            $data = explode('window._sharedData =',$html);
            if (empty($data[1])) \Yii::trace('Can`t find json data', 'parsing');

            $data = explode(';</script>',$data[1]);
            if (empty($data[0])) \Yii::trace('Can`t find json data', 'parsing');

            $data = json_decode($data[0],true);

            if (empty($data['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
							if (empty($data[0])) \Yii::trace('Can`t find json data entry_data ProfilePage 0 user media nodes', 'parsing');
							return false;
						}

            $param = [];
            foreach ($data['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $item) {

							$outItem = [];

							if ($item['date'] <= $last_update) {continue;}
							if (!empty($item['is_video'])) {

								\Yii::trace('it`s is video', 'parsing');

								$urlToItemWithVideo = 'https://www.instagram.com/p/' . $item['code']   . '/?taken-by=memebox_usa&__a=1';
								$mediaItemJson      = @file_get_contents($urlToItemWithVideo);
								$mediaItem          = json_decode($mediaItemJson,true);

								if (!empty($mediaItem['media']['video_url'])) {
									$outItem['video'] = $mediaItem['media']['video_url'];
									\Yii::trace('video url:'.$outItem['video'], 'parsing');
								}

							} else {
								$outItem['video'] = '';
							}

							$outItem['read_full_article'] = 'https://www.instagram.com/p/' . $item['code'];

							if (!isset($item['caption'])) {
								\Yii::trace('isset item caption(continue)', 'parsing'); continue;
							};

							$outItem['title'] = $item['caption'];
                // $title = ParsingRss::removeEmoji($item['caption']);
							$outItem['source_time'] = $item['date'];
							$outItem['content']     = '';

							$img              = $item['display_src'];
							$outItem['image'] = ParsingRss::imageSaver($img);

							if (!$outItem['image']) {
								\Yii::trace('No image(continue)', 'parsing');
								continue;
							};

							$outItem['hover_color'] = ParsingRss::addColorForImage($outItem['image']);

              // $path = Articles::getNextName($title2);

							$param[] = $outItem;

							\Yii::trace('Add param:'.\yii\helpers\VarDumper::dumpAsString($outItem), 'parsing');

            }

            return $param;
      }




      /*
      * Instagramm Using site iconosquare.com
      */
      public static function setInstagrammUsingIconsquare($feed, $last_update)
      {

          /*
          // < Parsing video

            // Generate main array
            $url_first = basename($feed);
            $url_xml = file_get_contents("http://iconosquare.com/feed/$url_first"); // учтонить, эта ли ссылка$data->entry_data->ProfilePage[0]->user->media->nodes[$i]->date
            $json = json_encode($xml);
            $array_photos = json_decode($json, true);

              foreach($array_photos['channel']['item'] as $item)
              {

                  if(isset($item['enclosure']['@attributes']['url'])){

                      // Link
                      $url = $item["link"];

                      // Date
                      $date = $item['pubDate'];
                      $date = self::generateRightDate($date);

                      // Generating video
                      $content =  '<iframe src="' . $item['enclosure']['@attributes']['url'] .
                                  '" type="' . $item['enclosure']['@attributes']['type'] . '" width="400"
                                  height="300" frameborder="0"></iframe>';

                      //$param[] = [$date,$content,1];
                      $title = "";
                      $image = "";
                      $param1[] = [$title,$date,$content,$image,1];

                  }

              }

          // >
          */

          // < Parsing images

                    $html = @file_get_contents($feed);

                    if(!$html)
                        return false;

                    // < Merge images and dates in one array $matches[2]

                        $array_channel = self::getXml($html);

                        if (empty($array_channel['channel']['item'])) return false;

                        $count = count($array_channel['channel']['item']);
                        // Select images from string
                        preg_match_all('/<img[^>]+src=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/', $html, $matches);

                        // Add dates for images
                        for($i = 0; $i < $count; $i++)
                        {
                            $dates = 'date' . $i;
                            $matches[2][$dates] = strtotime($array_channel['channel']['item'][$i]['pubDate']);
                        }
                    // >

                    $param = [];
                    date_default_timezone_set('Europe/London');

                    for($n = 0; $n < count($matches[2]) / 2; $n++)
                    {

                        $date = 'date' . $n;
                        if($matches[2][$date] <= $last_update)
                            continue;

                        // Date
                        //$date = date('d F Y', $matches[2][$date]);
                        $date = $matches[2][$date];

                        // Image
                        $img = $matches[2][$n];
                        $image = self::setRandom();

                        // Upload image to server
                        $file = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $image;
                        $title = $content = $video = $read_full_article = "";

                        if(!$image)
                          continue;

                          $current = file_get_contents($img);

                          if($current)
                          {
                              file_put_contents($file, $current);
                          }

                          // Generate array for insert to db
                          $param[] = [$title, $content, $image, $video, $date, $read_full_article, 1];
                    }

              /*
              // Generate main array
              $html = @file_get_contents($feed);

              if(!$html)
                return false;
              $html = strstr($html, '{"country_code');
              $html = strstr($html, '</script>', true);
              $html = substr($html, 0, -1);
              $data = json_decode($html, true);  //to array

              $param = [];
              date_default_timezone_set('Europe/London');

              foreach ($data['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $key => $node) {
                  if(!empty($node['is_video']))
                    continue;
                  if($node['date'] <= $last_update)
                    continue;

                  // Date
                  $date = date('d F Y', $node['date']);

                  // Image
                  $img = $node['thumbnail_src'];
                  $image = self::setRandom();

                  // Upload image to server
                  $file = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $image;
                  $title = $content = $video = $read_full_article = "";


                  if(!$image)
                    continue;

                  $current = file_get_contents($img);

                  if($current)
                  {
                      file_put_contents($file, $current);
                  }

                  // Generate array for insert to db
                  $param[] = [$title, $content, $image, $video, $date, $read_full_article, 1];
              }
              */


          return $param;

      }
}
