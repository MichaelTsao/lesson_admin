<?php

if (YII_ENV_DEV) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=123.57.173.192;dbname=new_lesson_dev',
        'username' => 'cx',
        'password' => 'Zhuxi$8520',
        'charset' => 'utf8',
    ];
}

if (YII_ENV_TEST) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=new_lesson_dev',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
}

if (YII_ENV_PROD) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=10.165.116.60;dbname=new_lesson',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
}
