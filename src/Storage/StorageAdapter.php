<?php
namespace Redbox\Crawl\Storage;

abstract class StorageAdapter
{
    /**
     * Since PSR-4 does not allow constructors to throw exceptions
     * we need to get creative. Every Adapter needs to verify that it can
     * be used.
     *
     * @return bool
     */
    public abstract function verifySupport();
    public abstract function add($key = '', $value = '');
    public abstract function get($key = '');
    public abstract function unset($key = '');
}