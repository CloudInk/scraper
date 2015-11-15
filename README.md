# scraper
MSNBC Headline Scraper
- Scrapes top 10 headlines (in order) from msnbc.com.

Scrapes: 
- Article Headline
- Article Body
- Article Image
- Article Link
   
Returns:
- JSON
- PHP Array


Usage:
```php 

include('scraper.php');
$s = new \TDW\IO\SCRAPER\scraper();

// Load the $s->articles array with only the index page data
$s->scrapeTarget('index');

// Load the $s->articles array with index and article body data
$s->scrapeTarget('index')->scrapeTarget('articles');

// Output the $s->articles array in JSON format
$s->printJSONScrapes();

// You can chain the object
$s->scrapeTarget('index')->scrapeTarget('articles')->printJSONScrapes();

//array generated after calling scrapeTarget()
$s->articles;  

// Generate single Article array scrapeSingleArticleBody($article_url)
// See the file: scraper-article-view.php for an example of how this is used
$s->scrapeSingleArticleBody($article_url);

// Single article array generated after scrapeSingleArticleBody() has been called
$s->article;

//prints array with <pre> tags
$s->print_rr($s->articles);

/*

Example: index and article scrape JSON response (truncated for this readme)
$s->scrapeTarget('index')->scrapeTarget('articles')->printJSONScrapes();

{  
   "ec23b4de927ebe98f7d5e1fe9ac72c3f6cf7c9d3":{  
      "article-title":"ISIS claims attacks",
      "article-link":"http:\/\/msnbc.com\/msnbc\/paris-attacks-france-hollande-blames-isis",
      "article-image-src":"http:\/\/www.msnbc.com\/sites\/msnbc\/files\/styles\/homepage--3-2--1_5x-1245x830\/public\/articles\/rts6zac__1447506091.jpg?itok=ByGHMqR0",
      "article-image-text":"French President Francois Hollande speaks with Prime Minister Manuel Valls at the Elysee Palace in Paris, France, Nov. 14, 2015, following a meeting the day after a series of deadly attacks in the French capital. (Photo by Philippe Wojazer\/Reuters)",
      "article-uid":"ec23b4de927ebe98f7d5e1fe9ac72c3f6cf7c9d3",
      "article-body":["some article body that is really super long text"]
   }
}
*/


/*

Example: index scrape JSON response (truncated for this readme)
$s->scrapeTarget('index')->printJSONScrapes();

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



/*

Example: Print PHP Array

// If you haven't already run scrapTarget('index')
$s->print_rr($s->scrapeTarget('index')->scrapeTarget('articles')->articles);

// If you have already run scrapeTarget('index') then $s->articles is already populated
$s->print_rr($s->articles);


Array
(
    [8a5508194288b21aa25ad2d5028bb0c493ebde9b] => Array
        (
            [article-title] => Terror in Paris
            [article-link] => http://msnbc.com/msnbc/paris-attacks-france-hollande-blames-isis
            [article-image-src] => http://www.msnbc.com/sites/msnbc/files/styles/homepage--3-2--1_5x-1245x830/public/rts6x0s__1447515937.jpg?itok=B1dJYFwn
            [article-image-text] => A French policeman assists a blood-covered victim near the Bataclan concert hall following attacks in Paris, France, Nov. 14, 2015. (Photo by Philippe Wojazer/Reuters)
            [article-uid] => 8a5508194288b21aa25ad2d5028bb0c493ebde9b
            [article-body] => Array
                (
                    [0] => PARIS - French President Francois Hollande vowed a merciless response to the deadliest attacks on the countrys soil since World War II. ISIS‚ claimed responsibility Saturday for a coordinated assault on Paris.
                    [1] => A state of emergency was declared and France deployed 1,500 troops after a near-simultaneous series of explosions and shootings brought the city to a horrified standstill overnight. The death toll rose to 127 and 200 other people were wounded, officials said.
                )

        )
)
*/
```
Easy as pie, use the ```scraper-view.php``` file for an example.
See it live at: http://tdw.io/scraper-view.php
