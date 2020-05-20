<?php


namespace WorkWechat\Actions;


use WorkWechat\Http\BaseRequest;

/**
 * 获取AccessToken
 * Class Gettoken
 * @package WorkWechat\Actions
 */
class Gettoken extends BaseRequest
{
    /**
     * 获取AccessToken
     * @param string $corpid 企业id
     * @param string $corpsecret 企业secret
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getAccessToken($corpid, $corpsecret)
    {
        return $this->HttpGet('/cgi-bin/gettoken', ['corpid' => $corpid, 'corpsecret' => $corpsecret]);
    }
}