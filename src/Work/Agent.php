<?php


namespace WorkWechat\Work;


use WorkWechat\Http\BaseRequest;

/**
 * 应用管理
 * Class Agent
 * @package WorkWechat\Ebs
 */
class Agent extends BaseRequest
{
    public function get($agentId)
    {
        $query['agentid'] = $agentId;

        return $this->HttpGet('/cgi-bin/agent/get', $query);
    }
}