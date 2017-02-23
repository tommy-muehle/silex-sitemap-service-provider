<?php

namespace TM\Service;

class SitemapGenerator
{
    /**
     * @var \XMLWriter
     */
    protected $sitemap;

    /**
     * @param \XMLWriter $xmlWriter
     * @param string     $version
     * @param string     $charset
     * @param string     $scheme
     */
    public function __construct(\XMLWriter $xmlWriter, $version = '1.0', $charset = 'utf-8', $scheme = 'http://www.sitemaps.org/schemas/sitemap/0.9')
    {
        $this->sitemap = $xmlWriter;
        $this->sitemap->openMemory();

        $this->sitemap->startDocument($version, $charset);
        $this->sitemap->setIndent(true);

        $this->sitemap->startElement('urlset');
        $this->sitemap->writeAttribute('xmlns', $scheme);
    }

    /**
     * @param string    $url
     * @param float     $priority
     * @param string    $changefreq
     * @param \DateTime $lastmod
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
