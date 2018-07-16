<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        'db' => [
            /*
            "host" => 'icelandmysqldb.ccwmdu7dvpes.us-east-2.rds.amazonaws.com',
            "dbname" => 'AccountEngine',
            "user" => 'IcelandDBMaster',
            "pass" => 'WL9T=Hv&u*k5BT*3'
		    */
            "host" => 'localhost',
            "dbname" => 'test',
            "user" => 'root',
            "pass" => ''
	
        ],
        'mail' => [
            'host' => 'email-smtp.us-east-1.amazonaws.com',
            'user' => 'AKIAINCMFFEAH4PXRD5Q',
            'pass' => 'AgDGGHVUUvxmeM9sJPstfxhOw3v2dzdZHK8P0rx3NqIt'
        ],
        'configuration' => [
            'correo_notificacion' => 'robotmodel67@gmail.com',
            'correo_notificacion' => 'svalencialozano@gmail.com',
            'nombre_notificacion' => 'Estefanía Gomez',
            'appPath' => '/app',
            'username' => 'egomez',
            'password' => 'Atlas1click'
        ],                
    ],
];