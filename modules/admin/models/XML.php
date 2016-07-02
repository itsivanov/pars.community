<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\ParsingRss;

class XML extends ParsingRss
{
	public static function get($feed)
	{
		$fileContent = @file_get_contents($feed);

		$xml  = simplexml_load_string($fileContent);

		$json     = json_encode($xml);
		$fileData = json_decode($json,true);

		$param = [];

		if (empty($fileData['channel'])) return false;
		$channel = $fileData['channel'];


		foreach ($channel['item'] as $item) {

			// echo $item['description'];
			// die();

			preg_match('/<img((?!src=\").)*src="([^\"]*)\"/',$item['description'],$matchesImg);

			preg_match('#<span[^>]*>((?!</span>).)*#',$item['description'],$matchesText);

			dd($matchesText);

			if (!empty($matchesImg[2])) {
				$image = self::imageSaver($matchesImg[2]);
			}

			$param[] = [
				'title'       => $item['title'],
				'description' => $item['description'],
				'pubDate'     => $item['pubDate'],
				'image'       => $image,
			];

			echo $item['description'];

			dd(0);
		}


		// dd($channel['item']);



		// dd($array_channel);

	}

}
