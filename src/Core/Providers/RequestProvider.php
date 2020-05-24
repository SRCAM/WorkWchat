<?php


namespace WorkWechat\Core\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['request'] = function () {
            return Request ::createFromGlobals();
        };
    }
}