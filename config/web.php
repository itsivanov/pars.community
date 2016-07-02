<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'   => 'basic',
		'name' => 'Fashion In Demand',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
       'admin' => [
           'class' => 'app\modules\admin\AdminModule',
       ],
			 'redactor' => [
					'class'     => 'yii\redactor\RedactorModule',
					'uploadDir' => '@webroot/uploads/articles',
					'uploadUrl' => '@web/uploads/articles',
					'imageAllowExtensions'=>['jpg','png','gif']
				],
     ],
    'components' => [

			'view' => [
					'theme' => [
							'basePath' => '@app/themes/watches',
							'baseUrl' => '@web/themes/watches',
							'pathMap' => [
									'@app/views' => '@app/themes/watches',
							],
					],
			],

        'cropimage' => [
            'class' => 'app\components\CropImage',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'baseUrl' => '/',
            'cookieValidationKey' => 'v_6QsFsJ1n9rYsSeNzEQiJ2BUTI0q5qT',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            // 'identityClass' => 'app\models\User',
            // 'enableAutoLogin' => true,

						'identityClass'   => 'app\modules\admin\models\User',
						'enableAutoLogin' => true,
						'loginUrl'        => ['admin/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,


        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
								[
										'logVars' => [],
										'class' => 'yii\log\FileTarget',
										'levels' => ['trace'],
										'categories' => ['parsing'],
										'logFile' => '@app/runtime/logs/parsing/process.log',
										'maxFileSize' => 1024 * 4,
										'maxLogFiles' => 20,
								],
								[
										'logVars' => [],
										'class' => 'yii\log\FileTarget',
										'levels' => ['trace'],
										'categories' => ['facebook'],
										'logFile' => '@app/runtime/logs/parsing/facebook.log',
										'maxFileSize' => 1024 * 2,
										'maxLogFiles' => 10,
								],
								[
										'logVars' => [],
										'class' => 'yii\log\FileTarget',
										'levels' => ['trace'],
										'categories' => ['youtube'],
										'logFile' => '@app/runtime/logs/parsing/youtube.log',
										'maxFileSize' => 1024 * 2,
										'maxLogFiles' => 10,
								],
            ],
        ],

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],

        'urlManager' => [
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
              'generate-sitemap'                => 'cron/generate-sitemap',
              'admin'                           => 'admin/',
              'rss'                             => 'site/rss',
              'rss/<category:[\+\w\d\s_-]+>'    => 'site/rss',
	            'page/<page:\d+>'                 => 'site/link-more',
              'search/<search_req:[\w\d\s_-]+>' => 'site/search',
              'article/<path:[\w\d\s_-]+>'      => 'page/index',
              'category/<category:[\+\w\d\s_-]+>'=> 'site/category',
              '<slug:[\w\d\s_-]+>'              => 'site/index',
            ]
        ],

        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.2.32', '91.211.176.169'],
    ];
}

return $config;
