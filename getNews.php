<?php
include_once('simple_html_dom.php');

function clear_links_file() {
    $file = 'links.txt';
    file_put_contents($file, '');
}

function clear_news_file() {
    $file = 'News.html';
    file_put_contents($file, '');
}

function fetch_xml($feedSource,$feedXMLFileName) {
    $feed = file_get_contents($feedSource);
    file_put_contents($feedXMLFileName,$feed);
    //echo 'Successfully fetched feed from ' . $feedSource . ' and written to file ' . $feedXMLFileName;
    //echo '<P>';
};


function writeLink($link) {
    $file = 'links.txt';
    $current = file_get_contents($file);
    $current .= $link.PHP_EOL;
    file_put_contents($file, $current);
};

function extract_summary($feedXMLFileName) {
    $xml = simplexml_load_file($feedXMLFileName);
    //echo 'Loaded file in $xml';
    //echo '<P>';

    foreach($xml->channel->item as $item)
    {
        $post->ts    = strtotime($item->pubDate);
        if($post->ts >= strtotime("-1 day") && $post->ts <= strtotime("now")) {

            $post->date  = (string) $item->pubDate;
            $post->link  = (string) $item->link;
            $post->title = (string) $item->title;
            $post->text  = (string) $item->description;
                
            //echo '<p>Title:'.$post->title;
            //echo '<p>PubDate:'.$post->date;
            //echo '<p>Link:'.$post->link;
            //echo '<p>---------------------';
            writeLink($post->link);
            echo $post->link;
            //aggregate($post->link);
            //sleep(1);
        }
    }
};

function aggregate($url) {
    $html = file_get_html($url);

    $title = $html->find('h1[class=detail-title]',0);
    echo '<h1>'. $title->plaintext . '</h1>';
    echo '<p>';
    $date = $html->find('div[class=artPubUpdate]',0);
    echo '<h4>'. $date->plaintext . '</h4><p>';
    
   
    $article = $html->find('div[class=article-text]',0);
    foreach($article->find('p[class=body]') as $articleText) {
        //$text = $text . '<p>' . $articleText;
        echo $articleText;
    }    
    echo '<hr>';
};

/*
function startTags() {
    $fileName = 'News.html';
    $fstream = file_put_contents($fileName,'<html><body>');
}

function endTags() {
    $fileName = 'News.html';
    $fstream = file_get_contents($fileName);
    $fstream = $fstream . ('</body></html>');
    file_put_contents($fileName, $fstream);
}
*/


clear_links_file();
clear_news_file();
//startTags();
fetch_xml('http://www.thehindu.com/news/?service=rss','TheHindu_XMLFeed.xml');
extract_summary('TheHindu_XMLFeed.xml');
//endTags();

?>		
