silex-sitemap-service-provider
==============================
[![Build Status](https://travis-ci.org/tommy-muehle/silex-sitemap-service-provider.svg?branch=master)](https://travis-ci.org/tommy-muehle/silex-sitemap-service-provider)
[![Latest Stable Version](https://poser.pugx.org/tm/silex-sitemap-service-provider/v/stable)](https://packagist.org/packages/tm/silex-sitemap-service-provider)
[![License](https://poser.pugx.org/tm/silex-sitemap-service-provider/license)](https://packagist.org/packages/tm/silex-sitemap-service-provider)
[![Issues](https://img.shields.io/github/issues/tommy-muehle/silex-sitemap-service-provider.svg)](https://github.com/tommy-muehle/silex-sitemap-service-provider/issues)
[![Total Downloads](https://poser.pugx.org/tm/silex-sitemap-service-provider/downloads)](https://packagist.org/packages/tm/silex-sitemap-service-provider)

The provider supports both major Versions of [Silex](http://silex.sensiolabs.org/).

### Installation

For applications based on Silex >= 2.0.0:

```
composer require tm/silex-sitemap-service-provider ^4.0
```

If you use Silex 1.3.x or lower in your application:

```
composer require tm/silex-sitemap-service-provider ^3.0
```

### Example Basic Usage

First you have to register the ServiceProvider:
```php
    $app->register(new TM\Provider\SitemapServiceProvider());
```

Optional you can also set some options for the generator:
```php
    $app->register(new TM\Provider\SitemapServiceProvider(), [
        'sitemap.options' => [
            'charset' => 'ISO-8859-1',
            'version' => '1.0',
            'scheme' => 'http://www.sitemaps.org/schemas/sitemap/0.8'
        ]
    ]);
```

Then implement the route for the sitemap.xml with your custom logic:
```php
    $app->get('sitemap.xml', function () use ($app) {
  
      $host = $app['request']->getSchemeAndHttpHost();
      
      $sitemap = $app['sitemap'];
      $sitemap->addEntry($host . '/', 1, 'yearly');
      
      $entities = $app['repository.entity']->findAll(50000);
  
      foreach ($entities as $entity) {
        $entityLoc = $app['url_generator']->generate('entity', array('entity' => $entity->getId()));
        $sitemap->addEntry($host . $entityLoc, 0.8, 'monthly', $entity->getLastModified());
      }
  
      return $sitemap->generate();
    })
    ->bind('sitemap');
```

You can implement a sitemapindex with the option "start" and the following example:
```php
    $app->register(new TM\Provider\SitemapServiceProvider(), [
        'sitemap.options' => [
            'charset' => 'ISO-8859-1',
            'version' => '1.0',
            'scheme' => 'http://www.sitemaps.org/schemas/sitemap/0.8',
            'start' => false
        ]
    ]);

    ...

    $app->get('sitemap.xml', function () use ($app) {
  
      $host = $app['request']->getSchemeAndHttpHost();
      
      $sitemap = $app['sitemap'];
      $sitemap
        ->startElement('sitemapindex')
        ->addSitemap($host . '/firstsitemap.xml')
        ->addSitemap($host . '/secondsitemap.xml', new \DateTime("yesterday"))
      ;
  
      return $sitemap->generate();
    })
    ->bind('sitemap');
```

### Contributing

Please refer to [CONTRIBUTING.md](CONTRIBUTING.md) for information on how to contribute.

### Development

Run tests with the following command in the project directory.

```
composer install
./vendor/bin/behat 
```
