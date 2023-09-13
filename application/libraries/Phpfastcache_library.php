<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Phpfastcache\CacheManager;

class Phpfastcache_library
{
    private $cache;

    public function __construct()
    {
        // Inisialisasi PHPFastCache
        $this->cache = CacheManager::getInstance('files');
    }

    public function get($key)
    {
        return $this->cache->getItem($key)->get();
    }

    public function set($key, $value, $ttl = 60)
    {
        $item = $this->cache->getItem($key);
        $item->set($value)->expiresAfter($ttl);
        $this->cache->save($item);
    }

    public function delete($key)
    {
        $this->cache->deleteItem($key);
    }

    public function clear()
    {
        $this->cache->clear();
    }
}