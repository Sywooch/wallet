<?php

return [
    'user' => 'user/default/index',
    'user/<action:\w+>' => 'user/default/<action>',
    'user/<controller:\w+>/<action:\w+>' => 'user/<controller>/<action>',
    '<controller:\w+>' => '<controller>/index',
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',


];