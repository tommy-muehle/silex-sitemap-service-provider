<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Silex\Application;
use TM\Provider\SitemapServiceProvider;

$app = new Application();
$app['debug'] = true;

$app->register(new SitemapServiceProvider());

return $app;