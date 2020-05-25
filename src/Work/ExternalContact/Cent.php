<?php


namespace WorkWechat\Work\ExternalContact;


use WorkWechat\Core\BaseClient;

class Cent extends BaseClient
{
    /**
     * 获取配置了客户联系功能的成员列表
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFollowUserList()
    {
        return $this->requestGet('cgi-bin/externalcontact/get_follow_user_list');
    }

    /**
     * 获取客户列表
     * @link https://work.weixin.qq.com/api/doc/90000/90135/92113
     * @param string $userId 企业成员的userid
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContactList(string  $userId)
    {
         return $this->requestGet('cgi-bin/externalcontact/list',['userid'=>$userId]);
    }

    /**
     * 获取客户详情
     * @param string $externalUserid
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDetails(string $externalUserid)
    {
        return $this->requestGet('cgi-bin/externalcontact/get',['external_userid'=>$externalUserid]);
    }

    public function ()
    {
        
    }
}