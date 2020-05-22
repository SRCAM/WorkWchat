<?php


namespace WorkWechat\Core\Traits;


use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface as SimpleCacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Cache\Simple\FilesystemCache;
use WorkWechat\Core\ServiceContainer;

trait WidthCache
{
    /**
     * @var
     */
    protected $cache;

    /**
     * 获取缓存配置
     * @return mixed
     */
    public function getCache()
    {
        if ($this->cache) {
            return $this->cache;
        }
        if (property_exists($this, 'app') && $this->app instanceof ServiceContainer && isset($this->app['cache'])) {
            $this->setCache($this->app['cache']);
            assert($this->cache instanceof \Psr\SimpleCache\CacheInterface);
            return $this->cache;
        }
        return $this->cache = $this->createDefaultCache();
    }

    public function setCache($cache)
    {
        if (empty(\array_intersect([SimpleCacheInterface::class, CacheItemPoolInterface::class], class_implements($cache)))) {
            //todo:: 缓存
        }
        if ($cache instanceof CacheItemPoolInterface) {
            if (!$this->isSymfony43()) {
                //todo:: 抛出错误
            }
            $cache = new Psr16Cache($cache);
        }
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return Psr16Cache|FilesystemCache
     */
    public function createDefaultCache()
    {
        if ($this->isSymfony43()) {
            return new Psr16Cache(new FilesystemAdapter('workwchat', 10000));
        }
        return new FilesystemCache();
    }

    /**
     * @return bool
     */
    protected function isSymfony43()
    {
        return \class_exists('Symfony\Component\Cache\Psr16Cache');
    }
}