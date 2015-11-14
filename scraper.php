<?php

/* Scraper V1 */
/* Class assumes you've installed the proper libs for DOM */
/* timdwalton@gmail.com */

class scraper
{

    /*
     * method __construct([string] url)
     * when a new scraper is born, we do this:
     * */
    function __construct($url = 'http://msnbc.com')
    {
        $this->url = $url; //construct param [url to scrape]
        $this->rcount = 10; //top # of news item to get all verbose with ;D (i wouldn't mess with this if i were you)
        $this->response = ''; //scraper error response
        $this->articles = []; //scraper articles array
        $this->doc = new DOMDocument(); //instantiate new dom object
        libxml_use_internal_errors(true); //suppress malformed html errors
        $this->doc->preserveWhiteSpace = false; //who needs white space?
        $this->doc->loadHTMLFile($this->url); //load the url into the dom object
        $this->xpath = new DOMXPath($this->doc); //instantiate xpath
    }

    /* Prints JSON formatted scrape */
    function printScrapes()
    {
        $scrapes = json_encode($this->articles);
        return print($scrapes);
    }

    /*
     * method scrape() [returns object]
     * Scrapes the DOM HTML document
     *
     * Searches the DOM for the CSS class(es) defined as:
     * $article_class_node [ DIV tag of the headline item ]
     * $article_link_node [  DIV tag of the link ]
     * $image_text_path [ absolute DOM path of IMG description ]
     * $image_src_path [ absolute DOM path of IMG src path ]
     *
    */

    // what you do to your windows when its cold outside..
    function scrape()
    {
        // Define all the dom nodes and tags and stuff..
        // IF you know xpath, or understand DOM structure this should
        // be pretty straight forward.

        $article_class_node = 'featured-slider-menu__item__link__title';
        $article_link_ref_node = 'featured-slider-menu__item__link';
        $image_text_path = "//div[@class='featured-slider__figure']/a/span";
        $results = $this->xpath->query("//*[@class='{$article_class_node}']");
        $links = $this->xpath->query("//*[@class='{$article_link_ref_node}']");
        $image_text_node = $this->xpath->query($image_text_path);

        $xs = 0;
        $xv = 1;
        while ($xs < 300) {
            // There are a ton of span elements inside the article > a tags on msnbc to filter through.
            // probably less than 300 but I wanted to be safe.
            $image_src_path = "//article[{$xv}]/div/a/span/span[5]/@data-src";
            $image_src_node = $this->xpath->query($image_src_path);
            @$article_images[] = ($image_src_node->item(0)->nodeValue);

            // kinda sloppy
            if ($xv != 10) {
                $xv++;
            }
            $xs++;
        }

        //chop all the nasty extra imgs from the array we made above..
        //we know msnbc has 10 headlines with photos so we will slice the array
        //there since there are only 10 unique article tags that need images.
        $article_images_arr = (array_slice($article_images, 0, $this->rcount));

        if ($results->length > 0) {
            $x = 0;
            $i = 1;
            //arguably faster than foreaach
            while ($x < $this->rcount) {
                $this->articles[$x]['article-title'] = $results->item($x)->nodeValue;
                $this->articles[$x]['article-link'] = "{$this->url}{$links->item($x)->attributes->getNamedItem('href')->nodeValue}";
                $this->articles[$x]['article-image-src'] = $article_images_arr[$x];
                $this->articles[$x]['article-image-text'] = $image_text_node->item($x)->attributes->getNamedItem('data-alt')->nodeValue;
                $x++;
                $i++;
            }
        }
        return $this;
    }

    function __destruct()
    {
        /* so I can sleep at night.. */
        unset($this);
    }
}

?>
