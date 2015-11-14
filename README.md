# scraper
MSNBC Headline Scraper

Usage:
```php
include('scraper.php');

$s = new scraper();

//You always have to call scrapeIndex() first -- it loads the array with the article URLs.

//Scrape Index and Articles, then output as JSON
$s->scrapeIndex()->scrapeIndexArticles()->printJSONScrapes();

//Scrape only Index, then output as JSON
$s->scrapeIndex()->printJSONScrapes();

//Scrape only Index, and don't output
$s->scrapeIndex();

//Scrape Index and Articles, and don't output
$s->scrapeIndex()->scrapeIndexArticles();

//Full article data is stored in 
$s->articles;

//To expose the array you can simply
$s->print_rr($s->articles);
```
Easy as pie, use the ```scraper-view.php``` file for an example.
See it live at: http://tdw.io/scraper-view.php
