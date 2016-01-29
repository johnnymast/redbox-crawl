<?php
namespace Redbox\Crawl\Dom\Elements;

abstract class DomElementAbstract implements DomElementInterface
{
    /**
     * @var bool
     */
    protected $is_valid;
    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var bool
     */
    protected $isSecure = false;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $scheme
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param boolean $isSecure
     */
    public function setIsSecure($isSecure)
    {
        $this->isSecure = $isSecure;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return boolean
     */
    public function isIsValid()
    {
        return $this->is_valid;
    }

    /**
     * @param boolean $is_valid
     */
    public function setIsValid($is_valid)
    {
        $this->is_valid = $is_valid;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return boolean
     */
    public function isIsSecure()
    {
        return $this->isSecure;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    public abstract function getTag();
    public abstract function verifyImplementation();
}