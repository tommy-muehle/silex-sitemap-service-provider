<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Silex\Application;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Silex\Application
     */
    protected $app;

    /**
     * Initializes context.
     */
    public function __construct()
    {
        $this->app = require __DIR__ . '/bootstrap.php';
    }

    /**
     * @Given Service is available
     */
    public function isServiceAvailable()
    {
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
}
