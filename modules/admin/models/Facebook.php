<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ParsingRss;
use app\modules\admin\models\Settings;

class Facebook extends ParsingRss
{

			//
			// public static function get($feed, $last_update)
			// {
			//
			// 	//$feed   = "https://www.facebook.com/valentino";
			// 	//$feed = "https://www.facebook.com/CulturemeterOdessa/";
			// 	$agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
			//
			// 	\Yii::trace('begin Facebook: '.$feed, 'facebook');
			//
			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// 	curl_setopt($ch, CURLOPT_VERBOSE, true);
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			// 	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			// 	curl_setopt($ch, CURLOPT_URL,$feed);
			// 	curl_setopt($ch, CURLOPT_HEADER,true);
			//
			// 	$response = curl_exec($ch);
			//
			// 	$headerSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			// 	$header      = substr($response, 0, $headerSize);
			// 	$body        = substr($response, $headerSize);
			//
			// 	curl_close($ch);
			//
			// 	$articles = explode('role="article"',$body);
			//
			// 	$param = [];
			//
			// 	if (count($articles) < 2) {
			// 		\Yii::trace('Cant find role="article"', 'facebook');
			// 		\Yii::trace($response, 'facebook');
			// 	}
			//
			// 	for ($i=0; $i < count($articles); $i++) {
			//
			// 		// Find image src
			// 		preg_match('/<a[^>]*(photos){1}[^>]*>((?!<\/a>).)*<img((?!src=\").)*src="([^\"]*)\"/',$articles[$i],$matchesImg);
			//
			// 		if (empty($matchesImg[4])) {
			// 			\Yii::trace('Cant find image', 'facebook');
			// 			\Yii::trace('Try find video', 'facebook');
			//
			// 			preg_match('/<\/video><div((?!\<img).)*<img((?!background-image: url\().)*background-image: url\(([^\)]*)/',$articles[$i],$matchesVideo);
			// 			// preg_match('/<\/video><div.*<img.*background-image: url\(([^\)]*)\)/',$articles[$i],$matchesVideo);
			//
			// 			if (empty($matchesVideo[3])) {
			// 				\Yii::trace('Cant find video', 'facebook');
			// 				continue;
			// 			}
			//
			// 			$img     = $matchesVideo[3];
			// 			preg_match_all('/<a((?!href=").)*href="([^"]*(?=videos\/)[^"]*)"/',$articles[$i],$matchesLink);
			//
			// 			if (!empty($matchesLink[2]) && !empty($matchesLink[2][0])) {
			// 				$read_full_article = 'https://www.facebook.com'.$matchesLink[2][0];
			// 			}
			//
			// 		} else {
			//
			// 			// Find link to unique article
			// 			preg_match_all('/<a ((?!href=").)*href="([^"]*(?=photo)[^"]*)"/',$articles[$i],$matchesLink);
			// 			if (!empty($matchesLink[2]) && !empty($matchesLink[2][0])) {
			// 				$read_full_article = 'https://www.facebook.com'.$matchesLink[2][0];
			// 			}
			//
			// 			$img     = $matchesImg[4];
			// 		}
			//
			//
			// 		preg_match('/<div[^>]*userContent[^>]*>(((?!<\/div>).)*<\/div>)/',$articles[$i],$matches);
			// 		if (empty($matches[1])) {
			// 			\Yii::trace('Cant find content', 'facebook');
			// 			continue;
			// 		}
			// 		$content =	strip_tags($matches[1]);
			//
			//
			// 		preg_match('/data-utime="([^"]*)"/',$articles[$i],$matchesDate);
			// 		if (empty($matchesDate[1])) {
			// 			\Yii::trace('Cant find date', 'facebook');
			// 			continue;
			// 		}
			// 		$date    = $matchesDate[1];
			//
			// 		if ($date <= $last_update) {
			// 			\Yii::trace('$date <= $last_update Facebook: '.$date, 'facebook');
			// 			continue;
			// 		}
			//
			//
			// 		$ext       = ParsingRss::getExt($img);
			// 		$imageName = ParsingRss::setRandom($ext);
			//
			// 		$image = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $imageName;
			//
			// 		$img = str_replace("&amp;", '&', $img);
			//
			// 		$ch2 = curl_init();
			//
			// 		curl_setopt($ch2, CURLOPT_URL, $img);
			// 		curl_setopt($ch2, CURLOPT_FAILONERROR, 1);
			// 		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
			// 		curl_setopt($ch2, CURLOPT_BINARYTRANSFER,1);
			// 		curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
			// 		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); // ignore SSL verifying
			// 		curl_setopt($ch2, CURLOPT_HEADER, 0);
			// 		curl_setopt($ch2, CURLOPT_USERAGENT, $agent);
			//
			// 		$response2 = curl_exec($ch2);
			//
			// 		curl_close($ch2);
			//
			// 		if (!$response2) {
			// 			\Yii::trace('Facebook !$response2', 'facebook');
			// 			continue;
			// 		}
			//
			// 		if(!@file_put_contents($image, $response2)) {
			// 			\Yii::trace('!@file_put_contents', 'facebook');
			// 			continue;
			// 		}
			//
			// 		//$image = ParsingRss::imageSaver($img);
			// 		/*
			// 		if (!$image) {
			// 			\Yii::trace('No image(continue)', 'facebook');
			// 			continue;
			// 		};
			// 		*/
			//
			// 		$hover_color = ParsingRss::addColorForImage($imageName);
			// 		$video = '';
			//
			//
			// 		$title = mb_substr($content,0,64);
			//
			// 		$param[] = [$title, $content, $imageName, $video, $date, $read_full_article, $hover_color, 1];
			// 		\Yii::trace('Add param:'.\yii\helpers\VarDumper::dumpAsString([$title, $content, $imageName, $video, $date, $read_full_article, $hover_color, 1]), 'facebook');
			// 	}
			//
			// 	return $param;
			// }
			//
			//
      // /*
      // * Facebook
      // */
      // public static function setFacebook($feed, $last_update)
      // {
      //   // Сгенерировать id по ссылке группы - https://www.facebook.com/groups/bizbloggingbuzz/
      //   // на сайте https://lookup-id.com/
      //   $url_xml = @file_get_contents($feed);
      //   if(!$url_xml)
      //     return false;
      //   // Array XML
      //   $array_channel = self::getXml($url_xml);
      //   $param = [];
      //   // Лишняя информация
      //   unset($array_channel['channel']['item'][0]);
			//
      //   foreach($array_channel['channel']['item'] as $item)
      //   {
      //       if(strtotime($item['pubDate']) <= $last_update)
      //         continue;
			//
      //       $str =  $item['description'];
			//
      //       if(strpos($str, "wrote") || strpos($str, "posted"))
      //       {
			//
      //           // Достаем из строки $str title и content
      //           if(strpos($str, "wrote")){
      //               $first_part = strpos($str, "wrote");
      //           }
      //           if(strpos($str, "posted")){
      //               $first_part = strpos($str, "posted");
      //           }
			//
      //           // Title (who posted)
      //           $title = substr($str, 0, $first_part);
			//
      //           $last_part = strpos($str, "wall");
			//
      //           // Content
      //           $post = substr($str, $last_part + 5);
      //           $post = preg_replace('/\(.*\)/', '', $post);
			//
      //           // < Insert links
      //           /*
      //               if(strpos($item['link'], '.gif'))
      //               {
      //                   echo "<img src='{$item["link"]}' />";
      //               }
      //               else
      //               {
      //                   echo "<a href='{$item["link"]}'>Link</a>";
      //               }
      //           */
      //           // >
			//
      //           // Date
      //           $date = $item['pubDate'];
      //           $date = self::generateRightDate($date);
      //           $link = $item['link'];
      //           $image = $video = "";
			//
      //           $param[] = [$title, $post, $image, $video, $date, $link, 1];
      //       }
      //   }
			//
      //
      //   return $param;
			//
      // }

			public static function getAccessToken() {

				if (!empty(Yii::$app->params['facebookAccessToken'])) return Yii::$app->params['facebookAccessToken'];

				$model = new Settings;

				$arr = $model->setSettings('get');
				$facebookAppId = $arr->facebook_app_id;
				$facebookAppSecret = $arr->facebook_app_secret;

				$url = 'https://graph.facebook.com/oauth/access_token'.
					'?grant_type=client_credentials'.
					'&client_id='.$facebookAppId.
					'&client_secret='.$facebookAppSecret;

				$request = self::getCurl($url);
				$data = json_decode($request);

				if (!empty($data->error)) {
					Yii::$app->params['facebookAccessToken'] = null;
				} else {
					Yii::$app->params['facebookAccessToken'] = $request;
				}

				return Yii::$app->params['facebookAccessToken'];
			}

			public static function getName($feed) {

				preg_match("#http(s)?://(www.)?facebook.com/([^/]*)#", $feed, $matches);

				if (!empty($matches[3])) {
					return $matches[3];
				}

				return null;
			}

			public static function getFeed($feed, $lastUpdate) {
				$data = self::getFeedData($feed);
				if (empty($data)) return false;

				$param = [];
				for ($i=0; $i < count($data); $i++) {

					$item = [];
					$date = strtotime($data[$i]['created_time']);

					if ($date <= $lastUpdate) {
						continue;
					}

					if (empty($data[$i]['name']) || $data[$i]['name'] == 'Timeline Photos') {

						if(!empty($data[$i]['message']))
							$title = mb_substr($data[$i]['message'],0,64);
						else
							$title = "Post";

					} else {
						$title = $data[$i]['name'];
					}

					if (empty($data[$i]['permalink_url'])) {
						$readFullArticle = $data[$i]['link'];
					} else {
						$readFullArticle = $data[$i]['permalink_url'];
					}

					if (empty($data[$i]['message'])) {
						if (empty($data[$i]['story'])) {
							$desc = $data[$i]['story'];
						} else {
							$desc = '';
						}

					} else {
						$desc = $data[$i]['message'];
					}

					$item = [
						'read_full_article' => $readFullArticle,
						'source_time'  => $date,
						'content'      => $desc,
						'title'        => $title,
					];

					if (empty($data[$i]['full_picture'])) continue;
					$imageName = self::uploadPhoto($data[$i]['full_picture']);
					if (empty($imageName)) continue;

					$item['image']       = $imageName;
					if (empty($item['image'])) continue;

					$item['hover_color'] = ParsingRss::addColorForImage($imageName);

					if (!empty($data[$i]['source'])) {
						$item['video'] = $data[$i]['source'];
					}

					$param[$i] = $item;

				}

				return $param;
			}

			public static function uploadPhoto($url) {

				$agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';

				$ch2 = curl_init();

				$url = str_replace("&amp;", '&', $url);

				curl_setopt($ch2, CURLOPT_URL, $url);
				curl_setopt($ch2, CURLOPT_FAILONERROR, 1);
				curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch2, CURLOPT_BINARYTRANSFER,1);
				curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); // ignore SSL verifying
				curl_setopt($ch2, CURLOPT_HEADER, 0);
				curl_setopt($ch2, CURLOPT_USERAGENT, $agent);

				$imageResponse = curl_exec($ch2);

				curl_close($ch2);

				if (!$imageResponse) {\Yii::trace('Facebook image response is break', 'facebook'); return false; }

				$ext       = ParsingRss::getExt($url);
				$imageName = ParsingRss::uniqidName($ext);
// dump($url);
// dump($imageName);
				$imageRoot = $_SERVER['DOCUMENT_ROOT'] . '/web/uploads/articles/' . $imageName;

				if (!file_put_contents($imageRoot, $imageResponse)) {\Yii::trace('!@file_put_contents', 'facebook');return false;}

				return $imageName;
			}

			public static function getFeedData($feed) {
				$name = self::getName($feed);

				$accessToken = self::getAccessToken();

				$url = 'https://graph.facebook.com/'.$name.'/feed'.
					'?'.$accessToken.
					'&fields=message,source,story,created_time,full_picture,permalink_url,name,link';

				$request = self::getCurl($url);
				$data = json_decode($request,true);

				if(empty($data['data']))
					return false;

				return $data['data'];
			}


			public static function getCurl($url) {

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore SSL verifying
				// curl_setopt($ch, CURLOPT_VERBOSE, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// curl_setopt($ch, CURLOPT_URL, 'graph.facebook.com/valentino?access_token=29b93a6bbcf3cd9311fd5a36f06e78e9');
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER,true);

				$response = curl_exec($ch);

				$headerSize  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$header      = substr($response, 0, $headerSize);
				$body        = substr($response, $headerSize);

				curl_close($ch);


				return $body;
			}

}
