<?php
namespace Redbox\Crawl\Transport;

interface TransportInterface
{

    /**
     * @param HttpRequest $request
     * @return mixed
     */
    public function sendRequest(HttpRequest $request);
}