<?php

namespace TM\Service;

class SitemapGenerator
{
    /**
     * @var \XMLWriter
     */
    protected $sitemap;

    /**
     * @var string scheme
     */
    protected $scheme;

    /**
     * @param \XMLWriter $xmlWriter
     * @param string     $version
     * @param string     $charset
     * @param string     $scheme
     */
    public function __construct(\XMLWriter $xmlWriter, $version = '1.0', $charset = 'utf-8', $scheme = 'http://www.sitemaps.org/schemas/sitemap/0.9', $start = true)
    {
        $this->sitemap = $xmlWriter;
        $this->sitemap->openMemory();

        $this->sitemap->startDocument($version, $charset);
        $this->sitemap->setIndent(true);

        if ($start) {
            $this->sitemap->startElement('urlset');
            $this->sitemap->writeAttribute('xmlns', $scheme);
        }
        $this->scheme = $scheme;
    }

    /**
     * @param string     $type
     * @return SitemapGenerator
     */
    public function startElement($type = 'urlset')
    {
        switch ($type) {
            case 'sitemapindex':
                $this->sitemap->startElement('sitemapindex');
                break;
            case 'urlset':
            default:
                $this->sitemap->startElement('urlset');
                break;
        }
        $this->sitemap->writeAttribute('xmlns', $this->scheme);

        return $this;
    }

    /**
     * @param string    $url
     * @param float     $priority
     * @param string    $changefreq
     * @param \DateTime $lastmod
     * @return SitemapGenerator
     */
    public function addEntry($url, $priority = 1.0, $changefreq = 'yearly', \DateTime $lastmod = null)
    {
        $this->sitemap->startElement('url');

        $this->sitemap->writeElement('loc', $url);
        $this->sitemap->writeElement('priority', $priority);
        $this->sitemap->writeElement('changefreq', $changefreq);

        if ($lastmod instanceof \DateTime) {
            $this->sitemap->writeElement('lastmod', $lastmod->format('Y-m-d'));
        }

        $this->sitemap->endElement();

        return $this;
    }

    /**
     * @param string    $url
     * @param \DateTime $lastmod
     * @return SitemapGenerator
     */
    public function addSitemap($url, \DateTime $lastmod = null)
    {
        $this->sitemap->startElement('sitemap');

        $this->sitemap->writeElement('loc', $url);

        if ($lastmod instanceof \DateTime) {
            $this->sitemap->writeElement('lastmod', $lastmod->format('Y-m-d'));
        }

        $this->sitemap->endElement();

        return $this;
    }

    /**
     * @param bool $doFlush
     *
     * @return string
     */
    public function generate($doFlush = true)
    {
        $this->sitemap->endElement();
        $this->sitemap->endDocument();

        return $this->sitemap->outputMemory($doFlush);
    }
}
