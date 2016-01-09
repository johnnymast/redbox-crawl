<?php
namespace Redbox\Crawl;
use Redbox\Crawl\DomTree;
use Redbox\Crawl\Transport\HttpRequest;

class Crawl {
    protected $domain;
    protected $transport;
    protected $pages = [];
    protected $url;

    public function __construct($domain='')
    {
        $this->domain = $domain;
        $this->transport = new Transport\Http;
    }

    private function parseTags($tag = "", $source ="")
    {
        /*** a new dom object ***/
        $dom = new \domDocument;

        @$dom->loadHTML($source);

        /*** remove silly white space ***/
        $dom->preserveWhiteSpace = false;

        /*** get the links from the HTML ***/
        $tags = $dom->getElementsByTagName($tag);

        return $tags;
    }

    private function crawlPages($url)
    {
       /*** return array ***/
        $ret = array();

        $request = new HttpRequest(
            $url,
            HttpRequest::REQUEST_METHOD_GET
        );

        /*** get the links from the HTML ***/
        $links = $this->parseTags('a', $this->transport->sendRequest($request));

        /*** loop over the links ***/
        foreach ($links as $tag)
        {
            $link = new DomTree\A($tag->getAttribute('href'), $this->domain);

            if ($link->getUrl()[0] == '#')
                continue;

            if ($link->getScheme() != 'https')
                $ret[$link->getUrl()] = $link;
        }

        $this->setPages($ret);
        return $this;
    }

    public function getTransport() {
        return $this->transport;
    }

    public function getInsecureContent($url)
    {
        $pages = $this->crawlPages($url);
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