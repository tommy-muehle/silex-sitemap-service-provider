<?php

namespace TM\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use TM\Service\SitemapGenerator;

/**
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
        $options = [
            'xml_writer' => new \XMLWriter,
            'version' => '1.0',
            'charset' => 'utf-8',
            'scheme' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
        ];

        if (isset($app['sitemap.options']) && is_array($app['sitemap.options'])) {
            $options = array_merge($options, $app['sitemap.options']);
        }

        $app['sitemap'] = $app->share(function () use ($options) {
            return new SitemapGenerator(
                $options['xml_writer'], $options['version'], $options['charset'], $options['scheme']
            );
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
