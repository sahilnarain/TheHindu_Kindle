<?php
include_once('simple_html_dom.php');
//$filename = 'links.txt';

header("Refresh: 0.1; URL=aggregateContent.php");

function read_and_delete_first_line($filename) {
  $filename = 'links.txt';
  $file = file($filename);
  $output = $file[0];
  echo $output;
 try {
  unset($file[0]);
   file_put_contents($filename, $file);
  aggregate($output);
  //read_and_delete_first_line($fileName);
  } catch(Exception $e) {
    exit();
  }
   return $output;
}

function aggregate($url) {
    $html = file_get_html($url);
    $fileName = 'News.html';
    $content = file_get_contents($fileName);
    
    $title = $html->find('h1[class=detail-title]',0);
    //echo '<h1>'. $title->plaintext . '</h1>';
    $content .= '<h1>'. $title->plaintext . '</h1>';
    //echo '<p>';
    $content .= '<p>';

    $date = $html->find('div[class=artPubUpdate]',0);
    //echo '<h4>'. $date->plaintext . '</h4><p>';
    $content .= '<h4>'. $date->plaintext . '</h4><p>';
    
    try {
    $article = $html->find('div[class=article-text]',0);
    foreach($article->find('p[class=body]') as $articleText) {
        //$text = $text . '<p>' . $articleText;
        //echo $articleText;
        $content .= $articleText;
    }    
    //echo '<hr>';
    $content .= '<hr>';
    } catch(Exception $e) { echo '<br>'; };
    file_put_contents($fileName, $content);
};

read_and_delete_first_line($filename);

?>
