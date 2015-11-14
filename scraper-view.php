<?php
include('scraper.php');
$s = new scraper();

if (isset($_GET['json']) && $_GET['json'] == 1) {
    header("Content-Type: application/json;");
    exit($s->scrapeIndex()->printJSONScrapes());
} elseif(isset($_GET['json']) && $_GET['json'] == 2) {
    header("Content-Type: application/json;");
    exit($s->scrapeIndex()->scrapeIndexArticles()->printJSONScrapes());
} else {
    $s->scrapeIndex()->scrapeIndexArticles();
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
            <li class='title'>Scraper v1 - Headlines - MSNBC Version <br>
                <small><a href="scraper-view.php?json=1">View JSON Output</a> | <a href="https://github.com/CloudInk/scraper">View Source</a> </small>
            </li>

        </ul>
    </div>
    <?php
    if (is_array($s->articles)) {
        $x = 0;
        foreach ($s->articles as $article) {

            echo "

                             <div class='small-4 columns' style=''>
                                <ul class='pricing-table' style='height: 521px;'>
                                    <li class='title'>{$article['article-title']}<br><small>{$s->url}</small></li>
                                    <li class='bullet-item'><img src='{$article['article-image-src']}' style='border: 2px #ccc solid; height: 200px; width:  400px;'></small></li>
                                    <li class='bullet-item'><small style='font-size:0.8em;'>{$article['article-image-text']}</small></li>
                                    <li class='cta-button'><a class='button' href='{$article['article-link']}'>Read Article</a></li>
                                </ul>
                            </div>

                            ";
            $x++;
        }
    }

    ?>

</div>
<hr>
<hr>
<div class="row">
    <div class='small-12 columns' style=''>
        <ul class='pricing-table'>
            <li class='title'>Scraper v1 - Articles - MSNBC Version <br>
                <small><a href="scraper-view.php?json=2">View JSON Output</a></small>
            </li>

        </ul>
    </div>
    <?php
    if (is_array($s->articles)) {
        $x = 0;
        foreach ($s->articles as $article) {

            echo "

                             <div class='small-14 columns' style=''>
                                <ul class='pricing-table' style='height: auto;'>
                                    <li class='title'>{$article['article-title']}<br><small>{$s->url}</small></li>
                                    <li class='bullet-item'><img src='{$article['article-image-src']}' style='border: 2px #ccc solid; height: 200px; width:  400px;'></small></li>
                                    <li class='bullet-item'><small style='font-size:0.8em;'>{$article['article-image-text']}</small></li>
                                    <li class='cta-button'>";

            if (is_array($article['article-body'])) {
                foreach ($article['article-body'] as $line) {
                    echo "<p style='text-align: left;'>{$line}</p>";
                }
            } else {
                echo "<a class='button' href='{$article['article-link']}'>Watch Video</a>";
            }


            echo "</li>
                                </ul>
                            </div>

                            ";
            $x++;
        }
    }

    ?>
    <div class='small-12 columns' style=''>
        <ul class='pricing-table'>
            <li class='title'>timdwalton@gmail.com</li>

        </ul>
    </div>
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
