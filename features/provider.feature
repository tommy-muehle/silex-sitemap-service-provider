Feature: Service works expected
  In order to generate a valid sitemap
  I need to be able to create some entries

  Scenario:
    Given Service is available
    And No entry was set
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>
    """

  Scenario:
    Given Service is available
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
    Given Service is available
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
    Given Service is available
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