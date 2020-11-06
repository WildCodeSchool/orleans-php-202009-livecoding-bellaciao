<?php

/**
 * This file define config constants .
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

define('ENV', getenv('ENV') ? getenv('ENV') : 'dev');

//Model (for connexion data, see unversionned db.php)
//VIew
define('APP_VIEW_PATH', __DIR__ . '/../src/View/');
define('APP_CACHE_PATH', __DIR__ . '/../temp/cache/');

define('HOME_PAGE', 'home/index');
