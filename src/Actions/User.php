<?php

namespace WorkWechat\Actions;

use WorkWechat\Http\BaseRequest;

class User extends BaseRequest
{
    /**
     * 创建用户
     * @param array $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function create($data)
    {
        return $this->httpPost('/cgi-bin/user/create', $data);
    }

    /**
     * 获取用户
     * @param string $userid 成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function get($userid)
    {
        return $this->httpGet('/cgi-bin/user/get', ['userid' => $userid]);
    }

    /**
     * 更新成员
     * @param string $id
     * @param array $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function update(string $id, array $data)
    {
        return $this->httpPostJson('/cgi-bin/user/update', array_merge(['userid' => $id], $data));
    }

    /**
     * 删除用户
     * @param string $userid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delete(string $userid)
    {
        return $this->httpGet('/cgi-bin/user/delete', ['userid' => $userid]);
    }

    /**
     * 批量删除用户
     * @param string $userids
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function batchDelete(array $userids)
    {
        return $this->httpPostJson('/cgi-bin/user/batchdelete', ['useridlist' => $userids]);
    }

    /**
     * 获取部门成员
     * @param int $department_id
     * @param bool $fetch_child
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getDepartmentUsers($departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            '$fetch_child' => (bool)$fetchChild
        ];
        return $this->httpGet('/cgi-bin/user/simplelist', $params);
    }

    /**
     * 获取部门成员详情
     * @param int $departmentId
     * @param int $fetchChild
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getDetailedDepartmentUsers(int $departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => (bool)$fetchChild
        ];
        return $this->httpGet('/cgi-bin/user/list', $params);
    }

    /**
     * userid转openid
     * @param string $userId 用户id
     * @param null $agentId
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function convertToOpenid($userId, $agentId = null)
    {
        $params = [
            'userid' => $userId,
            'agentid' => $agentId,
        ];
        return $this->httpPostJson('/cgi-bin/user/convert_to_openid', $params);
    }

    /**
     * openid转userid
     * @param string $openid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function convertToUserid(string $openid)
    {
        return $this->httpPostJson('/cgi-bin/user/convert_to_userid', ['openid' => $openid]);
    }

    /**
     * 二次验证
     * @param $userid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function proving(string $userId)
    {
        return $this->httpGet('/cgi-bin/user/authsucc', ['userid' => $userId]);
    }

    /**
     * 通过手机号码获取用户id
     * @param $mobile
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function mobileToUserId($mobile)
    {
        $params = [
            'mobile' => $mobile
        ];
        return $this->httpPostJson('/cgi-bin/user/getuserid', $params);
    }

    /**
     * 获取手机号随机串
     * @param int $mobile 手机号
     * @param string $state 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getMobileHashcode(int $mobile, $state = null)
    {
        $parmas = [
            'mobile' => $mobile,
            'state' => $state
        ];
        return $this->httpPostJson('cgi-bin/user/get_mobile_hashcode', $parmas);
    }

    /**
     * 获取企业活跃成员数
     * @param string $date 具体某天的活跃人数，最长支持获取30天前数据
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getActiveStat($date)
    {
        $parmas = [
            'date' => $date
        ];
        return $this->httpPostJson('/cgi-bin/user/get_active_stat', $parmas);
    }
}