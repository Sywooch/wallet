<?php

return [
    'login' => 'user/default/login',
    'logout' => 'user/default/logout',
    'signup' => 'user/default/signup',
    
    'transaction/create/<type:\w+>' => 'transaction/create',
    
    '<controller:\w+>' => '<controller>/index',
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',


//    '<module:\w+>' => '<module>/default/index',
    '<module:\w+>/<action:\w+>' => '<module>/default/<action>',
//    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',



];