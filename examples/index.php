<?php
require '../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

try {
    $crawl = new \Redbox\Crawl\Crawl('www.locovsworld.com');

    $link = "http://www.locovsworld.com/";
    $stream = new \Redbox\Crawl\Transport\Adapter\Stream();

    $crawl->getTransport()->setAdapter($stream);
    $found = $crawl->getInsecureContent($link);
    print '<pre>'.count($found). 'insecure links.</pre>';
    print '<pre>';
    print_r($found);
    echo 'DOne';
} catch (Exception $e) {
    print '<pre>';
    print_r($e->getMessage());
}

