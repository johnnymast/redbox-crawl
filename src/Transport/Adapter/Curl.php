<?php
namespace Redbox\Crawl\Transport\Adapter;

class Curl implements AdapterInterface
{
    /**
     * @var resource
     */
    protected $curl;

    /**
     * @var int
     */
    protected $timeout = 30;

    /**
     * @var int
     */
    protected $connect_timeout = 30;

    /**
     * Verify that we can support the curl extention.
     * If this is not the case we will throw a BadFunctionCallException.
     *
     * @throws BadFunctionCallException
     * @return bool
     */
    public function verifySupport()
    {
        if (!extension_loaded('curl')) {
            throw new \BadFunctionCallException('The cURL extension is required.');
        }
        return true;
    }

    /**
     * Initialize curl and close the connection if
     * needed.
     */
    public function open()
    {
        if (is_resource($this->curl)) {
            $this->close();
        }
        $this->curl = curl_init();
    }

    /**
     * Close the curl connection
     */
    public function close()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }


    /**
     * Send the request to the server.
     *
     * @param $address
     * @param $method
     * @param null $headers
     * @param null $body
     * @return mixed
     */
    public function send($address, $method, $headers = null, $body = null)
    {
        // Set connection options
        curl_setopt($this->curl, CURLOPT_URL, $address);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_VERBOSE, false); // FIXME
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false); /* Todo .. Debug only */
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);

        if (is_array($headers)) {
            $curlHeaders = array();
            foreach ($headers as $k => $v) {
                $curlHeaders[] = "$k: $v";
            }
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $curlHeaders);
        }

        if (is_array($body) === true && count($body) > 0) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        }
        return curl_exec($this->curl);
    }

    /**
     * Return the HTTP status code
     *
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * Return the content-type header set by the server.
     *
     * @return mixed
     */
    public function getContentType()
    {
        return curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE);
    }
}