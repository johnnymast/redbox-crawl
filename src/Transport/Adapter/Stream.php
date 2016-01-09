<?php
namespace Redbox\Crawl\Transport\Adapter;

class Stream implements AdapterInterface
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * HTTP Streams are always supported so return true.
     *
     * @return bool
     */
    public function verifySupport()
    {
        return true;
    }

    /**
     * @return void
     */
    public function open()
    {
       /* Nothing to do here */
    }

    /**
     * Close the connection.
     *
     * @return void
     */
    public function close()
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }

    /**
     * Send the request to the server.
     *
     * @param $address
     * @param $method
     * @param null $headers
     * @param null $body
     * @return bool|string
     */
    public function send($address, $method, $headers = null, $body = null)
    {
        $options = [
            'ignore_errors' => true,
            'method'        => $method,
            'headers'       => $headers,
        ];

        if (is_array($body) === true && count($body) > 0) {
            $options['content'] = $body;
        }

        $context = stream_context_create(
            ['http' => $options]
        );

        // Make request
        $this->resource = @fopen($address, 'r', false, $context);

        return $this->resource
            ? stream_get_contents($this->resource)
            : false;
    }

    /**
     * Return the HTTP status code.
     *
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        $headers = $this->getHeaders();
        $status = explode(' ', $headers[0]);
        return $status[1];
    }

    /**
     * Return the content-type of a request.
     * Returns false if no content-type could be found.
     *
     * @return bool|string
     */
    public function getContentType()
    {
        $headers = $this->getHeaders();
        foreach($headers as $header)
        {
            $needle = 'content-type:';
            $header    = strtolower($header);

            if (substr($header, 0, strlen($needle)) === 'content-type:') {
                $header = explode(';', $header);
                return trim(substr($header[0], strlen($needle)));
            }
        }
        return false;
    }

    /**
     * Return the stream headers.
     *
     * @return mixed
     */
    public function getHeaders()
    {
        return  stream_get_meta_data($this->resource)['wrapper_data'];
    }
}