<?php
namespace Redbox\Crawl\Transport;

class HttpRequest
{
    const REQUEST_METHOD_GET  = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT  = 'PUT';
    const REQUEST_EXPECTED_RESPONSE_TYPE_JSON = 'JSON';

    /**
     * @var int
     */
    protected $httpResponseCode;
    /**
     * @var array
     */
    protected $responseHeaders;
    /**
     * @var string
     */
    protected $responseBody;
    /**
     * @var string
     */
    protected $requestMethod;
    /**
     * @var array
     */
    protected $requestHeaders;
    /**
     * @var string
     */
    protected $expectedType;

    /**
     * @var array
     */
    protected $postBody;

    /**
     * @var string
     */
    protected $url;

    public function __construct($url = '', $method = 'GET', $headers = array(), $post_body = array(), $expected_type = self::REQUEST_EXPECTED_RESPONSE_TYPE_JSON)
    {
        $this->setUrl($url);
        $this->setRequestMethod($method);
        $this->setRequestHeaders($headers);
        $this->setPostBody($post_body);
        $this->setExpectedType($expected_type);
    }

    /**
     * @param string $expectedType XML/JSON
     */
    public function setExpectedType($expectedType)
    {
        $this->expectedType = strtoupper($expectedType);
    }

    /**
     * @param integer $httpResponseCode HTTP Response code
     */
    public function setHttpResponseCode($httpResponseCode)
    {
        $this->httpResponseCode = $httpResponseCode;
    }

    /**
     * @param array $postBody array of post parameters
     */
    public function setPostBody($postBody)
    {
        $this->postBody = $postBody;
    }

    /**
     * @param string $requestMethod HTTP Request method
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return mixed
     */
    public function getExpectedType()
    {
        return $this->expectedType;
    }

    /**
     * @param mixed $responseBody
     */
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @param array $responseHeaders of HTTP response headers
     */
    public function setResponseHeaders($responseHeaders)
    {
        $this->responseHeaders = $responseHeaders;
    }

    /**
     * @return integer HTTP response code
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    /**
     * @param array $requestHeaders array with request headers with keys and values
     */
    public function setRequestHeaders($requestHeaders)
    {
        $this->requestHeaders = $requestHeaders;
    }

    /**
     * @param string $url this should be a valid HTTP URL
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed response body
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return array HTTP Reponse headers
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * @return string HTTP Request Method
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @return array $requestHeaders as the headers set for this request
     */
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }

    /**
     * @return string url return the requested url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array of post body parameters
     */
    public function getPostBody()
    {
        return $this->postBody;
    }
}