<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/config.php';

$env = ENV;
if (getenv('ENV') !== false) {
    $env = getenv(ENV);
}

if (ENV == $env) {
    require_once __DIR__ . '/../config/debug.php';
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../src/routing.php';
