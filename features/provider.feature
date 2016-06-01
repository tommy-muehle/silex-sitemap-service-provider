Feature: Service works expected
  In order to generate a valid sitemap
  I need to be able to create some entries

  Scenario:
    Given Service with charset "utf-8", version "1.0" and scheme "http://www.sitemaps.org/schemas/sitemap/0.9" is available
    And No entry was set
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>
    """

  Scenario:
    Given Service with charset "utf-8", version "1.0" and scheme "http://www.sitemaps.org/schemas/sitemap/0.9" is available
    When I add an entry "https://tommy-muehle.de" with parameter "priority" and value "0.6"
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url>
        <loc>https://tommy-muehle.de</loc>
        <priority>0.6</priority>
        <changefreq>yearly</changefreq>
      </url>
    </urlset>
    """

  Scenario:
    Given Service with charset "utf-8", version "1.0" and scheme "http://www.sitemaps.org/schemas/sitemap/0.9" is available
    When I add an entry "https://tommy-muehle.de" with parameter "lastmod" and value "2014-01-18"
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url>
        <loc>https://tommy-muehle.de</loc>
        <priority>1</priority>
        <changefreq>yearly</changefreq>
        <lastmod>2014-01-18</lastmod>
      </url>
    </urlset>
    """

  Scenario:
    Given Service with charset "utf-8", version "1.0" and scheme "http://www.sitemaps.org/schemas/sitemap/0.9" is available
    When I add an entry "https://tommy-muehle.de" with parameter "priority" and value "0.8"
    And I add an entry "https://tommy-muehle.de/blog/" with parameter "priority" and value "1"
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url>
        <loc>https://tommy-muehle.de</loc>
        <priority>0.8</priority>
        <changefreq>yearly</changefreq>
      </url>
      <url>
        <loc>https://tommy-muehle.de/blog/</loc>
        <priority>1</priority>
        <changefreq>yearly</changefreq>
      </url>
    </urlset>
    """

  Scenario:
    Given Service with charset "ISO-8859-1", version "1.1" and scheme "http://www.sitemaps.org/schemas/sitemap/0.8" is available
    When I add an entry "https://github.com/tommy-muehle/silex-sitemap-service-provider" with parameter "lastmod" and value "2016-05-30"
    Then It should pass with:
    """
    <?xml version="1.1" encoding="ISO-8859-1"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.8">
      <url>
        <loc>https://github.com/tommy-muehle/silex-sitemap-service-provider</loc>
        <priority>1</priority>
        <changefreq>yearly</changefreq>
        <lastmod>2016-05-30</lastmod>
      </url>
    </urlset>
    """
