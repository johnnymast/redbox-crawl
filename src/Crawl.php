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

    // TODO recursive
    private function crawlPages($url)
    {
        $info = parse_url($url);

        /*** return array ***/
        $ret = array();

        /*** a new dom object ***/
        $dom = new \domDocument;

        $request = new HttpRequest(
            $url,
            HttpRequest::REQUEST_METHOD_GET
        );

        /*** get the HTML (suppress errors) ***/
        @$dom->loadHTML($this->transport->sendRequest($request));

        echo '<pre>@@'.$this->transport->getAdapter()->getContentType().'</pre>';

        /*** remove silly white space ***/
        $dom->preserveWhiteSpace = false;

        /*** get the links from the HTML ***/
        $links = $dom->getElementsByTagName('a');

        /*** loop over the links ***/
        foreach ($links as $tag)
        {
            $link = new DomTree\A($tag->getAttribute('href'), $this->domain);

            if ($link->getUrl()[0] == '#')
                continue;

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