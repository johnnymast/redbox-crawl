<?php
namespace Redbox\Crawl;
use phpDocumentor\Reflection\DocBlock\Tag\ParamTag;
use Redbox\Crawl\Dom;
use Redbox\Crawl\Dom\Elements;
use Redbox\Crawl\Transport\HttpRequest;

class Crawl {
    protected $domain;
    protected $transport;

    /**
     * @var Storage\StorageAdapter
     */
    protected $storage;

    /**
     * @var Dom\DomFactory
     */
    protected $domFactory;


    protected $pages = [];
    protected $url;

    public function __construct($domain='')
    {
        $this->domain = $domain;
        $this->transport = new Transport\Http;
        $this->domFactory = new Dom\DomFactory;
    }

    private function parseTags($tag = '', $source ="")
    {
        if (!$tag) {
            throw new Exception\CrawlException('Tag has type of null');
        }

        /*** a new dom object ***/
        $dom = new \domDocument;

        @$dom->loadHTML($source);

        /*** remove silly white space ***/
        $dom->preserveWhiteSpace = false;

        /*** get the links from the HTML ***/
      //  $tag->setTag('a');
        $tags = $dom->getElementsByTagName($tag);

        return $tags;
    }

    private function crawlPages($url)
    {
       /*** return array ***/
        $types = array(
            'a'   => array(),
            'img' => array(),
        );

        $request = new HttpRequest(
            $url,
            HttpRequest::REQUEST_METHOD_GET
        );


        foreach($types as $tag => $info) {

            /*** get the links from the HTML ***/
            $elements = $this->parseTags($tag, $this->transport->sendRequest($request));

            /*** loop over the links ***/
            foreach ($elements as $element)
            {

                $link = $this->domFactory->createElement($tag, $this->domain, $element);

                if ($link->getUrl()[0] == '#')
                    continue;

                if ($link->getScheme() != 'https')
                    $ret[$tag][] = $link;
            }

        }

        $this->setPages($ret);
        return $this;
    }

    /**
     * @return Dom\DomFactory
     */
    public function getDomFactory()
    {
        return $this->domFactory;
    }

    public function getStorage() {
        if (!$this->storage) {
            $this->storage = new Storage\Session;
        }
        if ($this->storage->verifySupport() == false) {
            throw new \Exception('The configured adapter could not be used. Tests show that its not ready.');
        }
        return $this->storage;
    }

    public function getTransport() {
        return $this->transport;
    }

    public function getInsecureContent($url)
    {
        $this->crawlPages($url);
        return $this->getPages();
    }

    private function setPages($pages = [])
    {
        $this->pages = $pages;
    }

    public function getPages() {
        return $this->pages;
    }

    /**
     * @param $storage
     * @return $this
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}