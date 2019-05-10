<?php
    define('CONTROLLER','\public\controller');
    define('MODEL','\public\model');
    define('VIEW','\public\view');
    define('ROUTE','\route');
    define('SUB_PATH_DOMAIN_NAME','/sql/');

    $ip = gethostbyname(gethostname());
    define('DOMAIN_NAME', $ip);

    define('DOMAIN', DOMAIN_NAME.SUB_PATH_DOMAIN_NAME);
