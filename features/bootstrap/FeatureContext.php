<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Silex\Application;
use TM\Provider\SitemapServiceProvider;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Silex\Application
     */
    private $app;

    /**
     * @Given Service with charset :charset, version :version and scheme :scheme is available
     */
    public function isServiceAvailable($charset, $version, $scheme)
    {
        $this->app = $this->generateApplication($charset, $version, $scheme);

        PHPUnit_Framework_Assert::assertArrayHasKey('sitemap', $this->app);
    }

    /**
     * @Given No entry was set
     */
    public function noEntryExists()
    {
        $sitemap = $this->app['sitemap']->generate(false);

        PHPUnit_Framework_Assert::assertNotRegExp(
            '/\<url\>/',
            $sitemap
        );
    }

    /**
     * @Then It should pass with:
     *
     * @param PyStringNode $string
     */
    public function isExpectedSitemap(PyStringNode $string)
    {
        $sitemap = $this->app['sitemap']->generate(false);

        PHPUnit_Framework_Assert::assertEquals(
            preg_replace('/(\s\s+|\t|\n)/', '', $string->getRaw()),
            preg_replace('/(\s\s+|\t|\n)/', '', $sitemap)
        );
    }

    /**
     * @param string $url
     * @param string $name
     * @param mixed  $value
     *
     * @When I add an entry :url with parameter :name and value :value
     */
    public function addEntry($url, $name = null, $value = null)
    {
        switch ($name)
        {
            case 'priority':
                $this->app['sitemap']->addEntry($url, $value);
                break;

            case 'lastmod':
                $datetime = new \DateTime($value);
                $this->app['sitemap']->addEntry($url, 1.0, 'yearly', $datetime);
                break;

            default:
                $this->app['sitemap']->addEntry($url);
        }
    }

    /**
     * @param string $charset
     * @param string $version
     * @param string $scheme
     */
    private function generateApplication($charset, $version, $scheme)
    {
        $options = [
            'debug' => true,
            'sitemap.options' => [
                'charset' => $charset,
                'version' => $version,
                'scheme' => $scheme,
            ]
        ];

        $app = new Application($options);
        $app->register(new SitemapServiceProvider);

        return $app;
    }
}
