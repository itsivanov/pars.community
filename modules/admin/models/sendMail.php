<?php

namespace app\modules\admin\models;
use Yii;

class sendMail
{

  function __construct()
  {

  }


 function send($subject, $message, $to)
 {
   $headers = $this->getHeaders($to);
   mail($to, $subject, $message, $headers);
 }


 function getHeaders($to)
 {
   return "From: fashion@gmail.com \r\n"
        . "Reply-To: fashion@gmail.com \r\n"
        . "CC: " . $to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: text/html; charset=ISO-8859-1\r\n";
 }

}
