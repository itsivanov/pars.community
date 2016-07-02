<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ParsingRss;
use app\modules\admin\models\Articles;

class Youtube extends ParsingRss
{

    /*
    * Youtube
    */
    public static function setYoutube($feed, $last_update)
    {
					\Yii::trace('Begin Youtube:'.$feed, 'youtube');

					$url_xml = @file_get_contents($feed);

					if(!$url_xml) {
						\Yii::trace('file_get_contents don`t return any', 'youtube');
						return false;
					}

          // Array XML
          $array_channel = self::getXml($url_xml);
          if(empty($array_channel['entry']))
            return [];

          $param = [];

					$list  = $array_channel['entry'];

					if (!empty($array_channel['entry']['id'])) {
						$list = [$array_channel['entry']];
					}

					foreach ($list as $item) {


						if(strtotime($item['published']) <= $last_update)
							continue;

							$outItem['title'] = $item['title'];


							// Generating the correct date
							$outItem['source_time'] = $item['published'];
							$outItem['source_time'] = self::generateRightDate($outItem['source_time']);

							// Insert links
							$url = $outItem['read_full_article'] = $item['link']['@attributes']['href'];


							// Generating video
							$parsed_url = parse_url($url);
							parse_str($parsed_url['query'], $parsed_query);

							$outItem['video'] =  '<iframe src="http://www.youtube.com/embed/' . $parsed_query['v'] . '" type="text/html" width="100%"
								height="500" frameborder="0"></iframe>';


							// The picture is the first frame of the video
							$img =  'http://img.youtube.com/vi/' .$parsed_query['v'] . '/mqdefault.jpg';
							$outItem['image'] = ParsingRss::imageSaver($img);


							if (!$outItem['image']) {
								\Yii::trace('No image(continue)', 'youtube');
								continue;
							};


							$outItem['hover_color'] = ParsingRss::addColorForImage($outItem['image']);
							$outItem['content']     = '';

							$param[] = $outItem;

							\Yii::trace('Add param:'.\yii\helpers\VarDumper::dumpAsString($outItem), 'youtube');

          }

          return $param;

      }

}
