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

    public function __construct()
    {

    }

    /* -- Setters */

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

    /* -- Getters -- */


    public function sendRequest(HttpRequest $request)
    {
        $this->getAdapter()->open();

        $data = $this->getAdapter()->send($request->getUrl(), $request->getRequestMethod(), $request->getRequestHeaders(), $request->getPostBody());
     //   $status_code = $this->getAdapter()->getHttpStatusCode();

        $this->getAdapter()->close();

        return $data;
    }
}