<?php
namespace Redbox\Crawl\Dom\Elements;

interface DomElementInterface {
    public function __construct(\DOMElement $element, $domain = '');
}