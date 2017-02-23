<?php

namespace TM\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use TM\Service\SitemapGenerator;

class SitemapServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
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

        $app['sitemap'] = function () use ($options) {
            return new SitemapGenerator(
                $options['xml_writer'], $options['version'], $options['charset'], $options['scheme']
            );
        };
    }
}
