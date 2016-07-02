<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactUs;
use app\modules\admin\models\Settings;


class ContactUsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $fullName = htmlspecialchars(strip_tags(trim($_POST['fullName'])));
        $eMail =    htmlspecialchars(strip_tags(trim($_POST['eMail'])));
        $webSite =  htmlspecialchars(strip_tags(trim($_POST['webSite'])));
        $subject =  htmlspecialchars(strip_tags(trim($_POST['subject'])));
        $message =  htmlspecialchars(strip_tags(trim($_POST['message'])));

        // Receive mail
        $model = new Settings;
        $arr = $model->setSettings('get');
        $email = $model->email = $arr->email;

        ContactUs::setContacts($fullName, $eMail, $webSite, $subject, $message, $email);
    }

}
