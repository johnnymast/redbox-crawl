<?php
namespace Redbox\Crawl\Dom\Elements;

class A extends DomElementAbstract {

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var bool
     */
    protected $on_domain;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $tag;


    public function __construct($args)
    {
        extract($args);

        if (isset($url) == false) {
            $this->error = 'Required parameter url was not set.';
            $this->setIsValid(false);
        }

        if (isset($domain) == false) {
            $this->error = 'required parameter domain was not set.';
            $this->setIsValid(false);
        }

        if ($this->isIsValid()) {
            $this->setUrl($url);

            $info = parse_url($url);
            if (is_array($info) == true) {

                if (isset($info['scheme']) == true) $this->setScheme($info['scheme']);
                if (isset($info['path']) == true) $this->setPath($info['path']);
                if (isset($info['host']) == true) $this->setHost($info['host']);

                $this->setIsOnDomain((bool)($this->getHost() === $domain));
            }
        }
    }

    public function verifyImplementation()
    {
        if ($this->error == true) {
            throw new \Exception($this->error);
        }
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * @return boolean
     */
    public function isOnDomain()
    {
        return $this->on_domain;
    }

    /**
     * @param boolean $on_domain
     */
    public function setIsOnDomain($on_domain)
    {
        $this->on_domain = $on_domain;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}