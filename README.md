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

/*
{  
   "ec23b4de927ebe98f7d5e1fe9ac72c3f6cf7c9d3":{  
      "article-title":"ISIS claims attacks",
      "article-link":"http:\/\/msnbc.com\/msnbc\/paris-attacks-france-hollande-blames-isis",
      "article-image-src":"http:\/\/www.msnbc.com\/sites\/msnbc\/files\/styles\/homepage--3-2--1_5x-1245x830\/public\/articles\/rts6zac__1447506091.jpg?itok=ByGHMqR0",
      "article-image-text":"French President Francois Hollande speaks with Prime Minister Manuel Valls at the Elysee Palace in Paris, France, Nov. 14, 2015, following a meeting the day after a series of deadly attacks in the French capital. (Photo by Philippe Wojazer\/Reuters)",
      "article-uid":"ec23b4de927ebe98f7d5e1fe9ac72c3f6cf7c9d3",
      "article-body":""
   }
}



*/

//Scrape only Index, and don't output
$s->scrapeIndex();

//Scrape Index and Articles, and don't output
$s->scrapeIndex()->scrapeIndexArticles();

//Full article array is stored in after scrapeIndex() has been called.
$s->articles;

//To expose the array you can simply
$s->print_rr($s->articles);
```
Easy as pie, use the ```scraper-view.php``` file for an example.
See it live at: http://tdw.io/scraper-view.php
