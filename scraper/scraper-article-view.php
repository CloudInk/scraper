<?php
include('scraper.php');
use \TDW\IO\ScrapeCore as scraper;
$s = new scraper();


if(isset($_GET['uid'])) {
    $s->scrape('index')->scrapeSingleArticleBody($_GET['uid']);
} else {
    header('location: /scraper/scraper-view.php');
}

if (is_array($s->articles)) {
    $x = 0;
    $article_links = '';
    foreach ($s->articles as $article) {
        if($article['article-link'] == $_GET['uid']){
            $arr = "

                             <div class='small-12 columns' style=''>
                                <ul class='pricing-table' style='height: 521px;'>
                                    <li class='title'>{$article['article-title']}<br><small><a href='{$article['article-link']}'>{$article['article-link']}</a> </small></li>
                                    <li class='bullet-item'><img src='{$article['article-image-src']}' style='border: 2px #ccc solid; height: 400px; width:  800px;'></small><br><small style='font-size:0.8em;'>{$article['article-image-text']}</small></li>
                                    <li class='description' style='height: auto; overflow: auto;'>{$s->article}</li>
                                    <li class='cta-button'><a class='button' href='{$article['article-link']}'>View on MSNBC.com</a></li>
                                </ul>
                            </div>

                            ";
        } else {
            $article_links .= " <a href='scraper-article-view.php?uid={$article['article-link']}'>{$article['article-title']}</a> &middot;";
        }
        $x++;
    }
}
?>


<!doctype html>
<!--[if IE 9]>
<html class="lt-ie10" lang="en"> <![endif]-->
<!--[if IE 10]>
<html class="ie10" lang="en"> <![endif]-->
<html class="no-js" lang="en" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TDW.IO | HOSTED API</title>
    <link rel="stylesheet" href="http://foundation.zurb.com/assets/css/templates/foundation.css"/>
    <script src="http://foundation.zurb.com/assets/js/modernizr.js"></script>
</head>
<body style="background-color: #fbfbfb;">

<div class="row">
    <div class='small-12 columns' style=''>
        <ul class='pricing-table'>
            <li class='title'>Scraper v1 - Article View - MSNBC Version <br>
                <small><a href="https://github.com/CloudInk/scraper">View Source</a> </small>
            </li>

        </ul>
    </div>
    <div class='small-12 columns' style=''>
        <ul class='pricing-table'>
            <li class='bullet-item'><a href="scraper-view.php"><strong>Back to Headlines</strong></a><hr> Trending<br> <?=$article_links;?></li>

        </ul>
    </div>
    <?php

    echo $arr;

    ?>

</div>

<script src="http://foundation.zurb.com/assets/js/jquery.js"></script>
<script src="http://foundation.zurb.com/assets/js/templates4/foundation4.js"></script>
<script>
    $(document).foundation();
    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);
</script>
</body>
</html>