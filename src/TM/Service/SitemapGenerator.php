<?php

namespace TM\Service;

/**
 * Class SitemapGenerator
 *
 * @package TM\Service
 */
class SitemapGenerator
{
    /**
     * @var \XMLWriter
     */
    private $map;

    /**
     * @var string
     */
    private $scheme = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->map = new \XMLWriter();

        $this->map->openMemory();
        $this->map->startDocument('1.0', 'utf-8');
        $this->map->setIndent(true);

        $this->startSitemap();
    }

    /**
     * @param string    $url
     * @param float     $priority
     * @param string    $changefreq
     * @param \DateTime $lastmod
     */
    public function addEntry($url, $priority = 1.0, $changefreq = 'yearly', \DateTime $lastmod = null)
    {
        $this->map->startElement('url');

        $this->map->writeElement('loc', $url);
        $this->map->writeElement('priority', $priority);
        $this->map->writeElement('changefreq', $changefreq);

        if (false === is_null($lastmod)) {
            $this->map->writeElement('lastmod', $lastmod->format('Y-m-d'));
        }

        $this->map->endElement();
    }

    /**
     * @param bool $flush
     *
     * @return string
     */
    public function generate($flush = true)
    {
        $this->endSitemap();

        return $this->map->outputMemory($flush);
    }

    /**
     * @return void
     */
    protected function startSitemap()
    {
        $this->map->startElement('urlset');
        $this->map->writeAttribute('xmlns', $this->scheme);
    }

    /**
     * @return void
     */
    protected function endSitemap()
    {
        $this->map->endElement();
        $this->map->endDocument();
    }
}