<?php

/* Scraper V1 */
/* Class assumes you've installed the proper libs for DOM */
/* timdwalton@gmail.com */

class scraper
{

    function __construct($url = 'http://msnbc.com')
    {
        $this->url = $url;
        $this->rcount = 10;
        $this->response = '';
        $this->articles = [];
        $this->doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $this->doc->preserveWhiteSpace = false;
        $this->doc->loadHTMLFile($this->url);
        $this->xpath = new DOMXPath($this->doc);
    }

    function printScrapes()
    {
        $scrapes = json_encode($this->articles);
        return print($scrapes);
    }

    function scrape()
    {

        $article_class_node = 'featured-slider-menu__item__link__title';
        $article_link_ref_node = 'featured-slider-menu__item__link';
        $image_text_path = "//div[@class='featured-slider__figure']/a/span";
        $results = $this->xpath->query("//*[@class='{$article_class_node}']");
        $links = $this->xpath->query("//*[@class='{$article_link_ref_node}']");
        $image_text_node = $this->xpath->query($image_text_path);

        $xs = 0;
        $xv = 1;
        while ($xs < 300) {
            $image_src_path = "//article[{$xv}]/div/a/span/span[5]/@data-src";
            $image_src_node = $this->xpath->query($image_src_path);
            @$article_images[] = ($image_src_node->item(0)->nodeValue);

            if ($xv != 10) {
                $xv++;
            }
            $xs++;
        }

        $article_images_arr = (array_slice($article_images, 0, $this->rcount));

        if ($results->length > 0) {
            $x = 0;
            $i = 1;
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
