<?php
namespace Redbox\Crawl\Transport;
use Redbox\Crawl\Exception;
use Redbox\Crawl\Transport\Adapter;
use Redbox\Crawl\Transport\Adapter\Curl as DefaultAdapter;

use Redbox\Crawl;

class Http implements TransportInterface
{
    /**
     * @var Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var int
     */
    protected $http_status_code;
    /**
     * @var string
     */
    protected $content_type;

    /**
     * Set the Transport adapter we will use to communicate
     * to Twitch.
     *
     * @param Adapter\AdapterInterface $adapter
     */
    public function setAdapter($adapter)
    {
        /**
         * Not a adapter throws a BadFunctionCallException or true
         * if usable.
         */
        if ($adapter->verifySupport() === true) {
            $this->adapter = $adapter;
        }
    }

    /**
     * Returns the Adapter set to communicate to Twitch.
     * If none is set we will try to work with Curl.
     *
     * @return Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->setAdapter(new DefaultAdapter);
        }
        return $this->adapter;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->http_status_code;
    }

    /**
     * @param int $http_status_code
     */
    public function setHttpStatusCode($http_status_code)
    {
        $this->http_status_code = $http_status_code;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param string $content_type
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
    }

    /* -- Getters -- */


    public function sendRequest(HttpRequest $request)
    {
        $this->getAdapter()->open();

        $data = $this->getAdapter()->send($request->getUrl(), $request->getRequestMethod(), $request->getRequestHeaders(), $request->getPostBody());

        $this->setHttpStatusCode($this->getAdapter()->getHttpStatusCode());

        $this->setContentType($this->getAdapter()->getContentType());

        $this->getAdapter()->close();

        return $data;
    }
}