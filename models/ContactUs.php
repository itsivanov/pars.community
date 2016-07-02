<?php

namespace app\models;

use Yii;

class ContactUs extends \yii\db\ActiveRecord
{

    /*
    *  Writing data in the form of a database
    */
    public static function setContacts($fullName, $eMail, $webSite, $subject, $message, $email)
    {
        // Writing in DB
        date_default_timezone_set('Europe/Kiev');
        $date_c = date('d F Y H:i:s');

        $new_message = "1";

        $sql = "INSERT INTO contact_us (name, email, 	site, subject, message, date_c, new_message)
                VALUES ('$fullName', '$eMail', '$webSite', '$subject', '$message', '$date_c', '$new_message')";

        Yii::$app->db->createCommand($sql)->execute();


        // Send in mail
        $message = "Full name: " . $fullName . '<br/>' .
                   "E-Mail: "    . $eMail    . '<br/>' .
                   "Web site: "  . $webSite  . '<br/>' .
                   "Subject: "   . $subject  . '<br/>' .
                   "Message: "   . $message  . '<br/>';

        Yii::$app->mailer->compose()
                         ->setFrom('from@domain.com')
                         ->setTo($email)
                         ->setSubject("Contact Us")
                         ->setHtmlBody($message)
                         ->send();
    }

}
