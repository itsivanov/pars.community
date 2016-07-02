<?php 

namespace app\helper;
use Yii;

class  Helper
{
	public static function postFilter($variable)
	{
		return trim ( strip_tags ( stripslashes($variable) ) );
	} 
}