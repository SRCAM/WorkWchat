<?php


namespace WorkWechat\Core\Providers;


use Pimple\Container;
use WorkWechat\Core\Config;
use Pimple\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}