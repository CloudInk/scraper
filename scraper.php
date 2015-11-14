<?php

/* Scraper V1 */
/* Class assumes you've installed the proper libs for DOM */
/* timdwalton@gmail.com */
/* For usage see: https://github.com/CloudInk/scraper/blob/master/README.md */

class scraper
{

    function __construct()
    {
        $this->url = 'http://msnbc.com';
        $this->rcount = 10;
        $this->response = '';
        $this->articles = [];
        $this->article = [];
        $this->doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $this->doc->preserveWhiteSpace = false;
        $this->xpath = '';

    }

    function flatten(array $array)
    {
        $return = array();
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });
        return $return;
    }

    function printJSONScrapes()
    {
        $scrapes = json_encode($this->articles);
        return print($scrapes);
    }

    function print_rr($what)
    {
        echo "<pre>";
        print_r($what);
        echo "</pre>";
        return $this;
    }

    function scrapeTarget($target = 'index')
    {
        switch($target) {
            case 'index':
                $this->scrapeIndex();
                break;
            case 'articles':
                $this->scrapeIndexArticles();
                break;
            case 'single':
                $this->scrapeSingleArticle();
                break;
            default:
                $this->scrapeIndex();
                break;
        }
        return $this;
    }

    function scrapeIndex()
    {
        $this->doc->loadHTMLFile($this->url);
        $this->xpath = new DOMXPath($this->doc);
        $results = $this->xpath->query("//*[@class='featured-slider-menu__item__link__title']");
        $links = $this->xpath->query("//*[@class='featured-slider-menu__item__link']");
        
        $xs = 0;
        $xv = 1;
        while ($xs < 200) {
            $image_src_node = $this->xpath->query("//article[{$xv}]/div/a/span/span[5]/@data-src");
            $image_alt_node = $this->xpath->query("//article[{$xv}]/div/a/span/@data-title");
            if($image_alt_node->length > 0) {
                @$article_alts[] = ($image_alt_node->item(0)->nodeValue);
            } else {
                $image_alt_node = $this->xpath->query("//article[{$xv}]/div/a/img/@alt");
                @$article_alts[] = ($image_alt_node->item(0)->nodeValue);
            }
            if($image_src_node->length > 0) {
                @$article_images[] = ($image_src_node->item(0)->nodeValue);
            } else {
                $image_src_node = $this->xpath->query("//article[{$xv}]/div/a/img/@src");
                @$article_images[] = ($image_src_node->item(0)->nodeValue);
            }
            if ($xv != 10) {
                $xv++;
            }
            $xs++;
        }
        $article_images_arr = (array_slice($article_images, 0, $this->rcount));
        $article_alts_arr = (array_slice($article_alts, 0, $this->rcount));
        if ($results->length > 0) {
            $x = 0;
            $i = 1;
            while ($x < $this->rcount) {
                $uid = sha1(md5(rand(111111,999999)));
                $this->articles[$uid]['article-title'] = $results->item($x)->nodeValue;
                $this->articles[$uid]['article-link'] = "{$this->url}{$links->item($x)->attributes->getNamedItem('href')->nodeValue}";
                $this->articles[$uid]['article-image-src'] = $article_images_arr[$x];
                $this->articles[$uid]['article-image-text'] = $article_alts_arr[$x];//$image_text_node->item($x)->attributes->getNamedItem('data-alt')->nodeValue;
                $this->articles[$uid]['article-uid'] = $uid;
                $this->articles[$uid]['article-body'] = '';
                $x++;
                $i++;
            }
        }
        return $this;
    }


    function scrapeIndexArticles()
    {

        /*if($image_src_node->length == 0 || $image_alt_node->length == 0) {
            $image_src_node = $this->xpath->query("//article[{$xv}]/div/a/img/@src");
            $image_alt_node = $this->xpath->query("//article[{$xv}]/div/a/img/@alt");
        }*/

        foreach($this->articles as $article) {
            $this->doc->loadHTMLFile($this->articles[$article['article-uid']]['article-link']);
            $this->xpath = new DOMXPath($this->doc);
            $article_body = $this->xpath->query("//div[contains(@class,'pane-content')]/div[@class='field field-name-body field-type-text-with-summary field-label-hidden']/p");
            $x = 0;
            $i = 1;
            while($x < $article_body->length) {
                $article_body_content = $this->xpath->query("//div[contains(@class,'pane-content')]/div[@class='field field-name-body field-type-text-with-summary field-label-hidden']/p[{$i}]");
                $this->articles[$article['article-uid']]['article-body'][] = trim(preg_replace('/\s\s+/', ' ', $article_body_content->item(0)->nodeValue));
                $x++;
                $i++;
            }
        }
        return $this;
    }

    function scrapeSingleArticleBody($article_url)
    {
        $this->doc->loadHTMLFile($article_url);
        $this->xpath = new DOMXPath($this->doc);
        $article_body = $this->xpath->query("//div[contains(@class,'pane-content')]/div[@class='field field-name-body field-type-text-with-summary field-label-hidden']/p");
        $x = 0;
        $i = 1;
        while($x < $article_body->length) {
            $article_body_content = $this->xpath->query("//div[contains(@class,'pane-content')]/div[@class='field field-name-body field-type-text-with-summary field-label-hidden']/p[{$i}]");
            $out['article-body'][] = trim(preg_replace('/\s\s+/', ' ', $article_body_content->item(0)->nodeValue));
            $x++;
            $i++;
        }
        $body = '';
        if(!isset($out)) {
            $this->article = "<a class='button' href='{$article_url}'>Watch Video</a>";
            return $this;
        }
        foreach($out['article-body'] as $line) {
            $body .= "<p style='font-size: 1.6em; color: #666; text-align: left; float: left; margin: 2px; padding: 4px;'>{$line}</p>";
        }
        $this->article = $body;
        return $this;
    }


    function __destruct()
    {
        /* so I can sleep at night.. */
        unset($this);
    }
}

?>
