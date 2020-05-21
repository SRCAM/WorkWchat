<?php

namespace WorkWechat;

class Factory
{
    private static $config;
    /**
     * @param array $config [corp_id=>企业id agent_id=>应用id  secret=>密匙]
     * @param array $config
     * @return Container
     */
    public static function create($config)
    {
        self::initComon($config);
        return Container::getInstance();
    }

    /**
     * 应用初始化
     * @param array $config [corp_id=>企业id agent_id=>应用id  secret=>密匙]
     */
    public static function initComon($config)
    {

        if (!isset($config['corp_id'])) {
            //todo:抛出异常
        }
        if (!isset($config['agent_id'])) {

        }

        if (!isset($config['secret'])) {

        }
        self::$config = $config;
        //检查access_token 是否存在
        self::findAccessToken();

    }

    private static function getTokenPath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'TokenFile';
    }

    private static function findAccessToken()
    {
        $config = self::$config;
        $tokenDir = self::getTokenPath();
        if (!is_dir($tokenDir)) {
            @mkdir($tokenDir, 0777);
        }
        // 读取文件
        $tokenFile = $tokenDir . DIRECTORY_SEPARATOR . $config['corp_id'] . '.json';
        if (!is_file($tokenFile)) {
            $access_token = self::createAccessToken();
        } else {
            $file = file_get_contents($tokenFile);
            $data = json_decode($file, true);
            if (time() > $data['exp_time']) {
                $access_token = self::createAccessToken();
            } else {

                $access_token = $data['access_token'];
            }
        }
        $config = array_merge($config, ['access_token' => $access_token]);
        Container::getInstance()->setConfig($config);
        return $access_token;
    }

    /**
     *创建token
     */
    public static function createAccessToken()
    {
        $config = self::$config;
        $tokenDir = self::getTokenPath();
        $gettoken = Container::getInstance()->gettoken;
        $gettoken = $gettoken->getAccessToken($config['corp_id'], $config['secret']);
        $tokenFile = $tokenDir . DIRECTORY_SEPARATOR . $config['corp_id'] . '.json';
        $data['access_token'] = $gettoken['access_token']; //token 设置
        $data['exp_time'] = time() + $gettoken['expires_in'] - 60; //过期时间设置
        file_put_contents($tokenFile, json_encode($data, JSON_HEX_AMP));
        return $gettoken['access_token'];
    }
}