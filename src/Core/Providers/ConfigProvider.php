<?php


namespace WorkWechat\Core\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use WorkWechat\Core\Config;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function ($app) {
            return new Config($app);
        };
    }
}