<?php
namespace Redbox\Crawl\Storage;


class Session extends StorageAdapter
{
    public function add($key = '', $value = '')
    {
        // TODO: Implement add() method.
    }

    public function get($key = '')
    {
        // TODO: Implement get() method.
    }

    public function unset($key = '')
    {
        // TODO: Implement unset() method.
    }

    public function verifySupport()
    {
        if (session_status() == PHP_SESSION_NONE) {
           return false;
        }
        return true;
    }

}