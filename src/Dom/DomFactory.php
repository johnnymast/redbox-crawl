<?php
namespace Redbox\Crawl\Dom;
use Redbox\Crawl\Dom\Elements;
use Redbox\Crawl\Exception;

class DomFactory
{
    protected $supported = [];

    public function __construct()
    {
        $this->supported = [
          'a' => 'A',
        ];
    }

    public function create($tag='', $args = [])
    {
        if (in_array($tag, array_keys($this->supported)) == true) {
            $class = 'Redbox\Crawl\Dom\Elements\\'.$this->supported[$tag];;
            $instance =  new $class($args);
            $instance->verifyImplementation();
            return $instance;
        } else {
            throw new Exception\CrawlException('Undefined DOM element '.$tag);
        }
    }
}