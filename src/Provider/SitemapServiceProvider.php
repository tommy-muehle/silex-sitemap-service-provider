<?php

namespace TM\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use TM\Service\SitemapGenerator;

/**
 * Class SitemapServiceProvider
 *
 * @package TM\Provider
 */
class SitemapServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['sitemap'] = $app->share(function ($app) {
            return new SitemapGenerator();
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app An Application instance
     */
    public function boot(Application $app)
    {
    }
}