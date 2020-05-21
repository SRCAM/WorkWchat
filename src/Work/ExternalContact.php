<?php


namespace WorkWechat\Work;


use WorkWechat\Exception\ArgumentException;
use WorkWechat\Http\BaseRequest;

/**
 * 外部联系人
 * Class ExternalContact
 * @package WorkWechat\Actions
 */
class ExternalContact extends BaseRequest
{

    /**
     * 获取配置了客户联系功能的成员列表
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getFollowUserList()
    {
        return $this->httpGet('/cgi-bin/externalcontact/get_follow_user_list');
    }

    /**
     * 配置客户联系「联系我」方式
     * @param int $type 联系方式类型,1-单人, 2-多人
     * @param int $scene 场景，1-在小程序中联系，2-通过二维码联系
     * @param array $config
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function addContactWay(int $type, int $scene, array $config = [])
    {
        $data = array_merge([
            'type' => $type,
            'scene' => $scene
        ], $config);
        return $this->httpPostJson('/cgi-bin/externalcontact/add_contact_way', $data);
    }

    /**
     * 获取企业已配置的「联系我」方式
     * @param string $configId 联系方式的配置id
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getContactWay(string $configId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/add_contact_way', ['config_id' => $configId]);
    }

    /**
     * update_contact_way
     * @param string $configId 企业联系方式的配置id
     * @param array $config 配置
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function updateContactWay(string $configId, array $config = [])
    {
        $data = array_merge([
            'config_id' => $configId,
        ], $config);
        return $this->httpPostJson('/cgi-bin/externalcontact/update_contact_way', $data);
    }

    /**
     * 删除企业已配置的「联系我」方式
     * @param string $configId 企业联系方式的配置id
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delContactWay(string $configId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/del_contact_way', ['config_id' => $configId]);
    }

    /**
     * 获取客户列表
     * @param int $userId 企业成员的userid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getExternalContactList(int $userId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/list', ['userid' => $userId]);
    }

    /**
     * 获取客户详情
     * @param string $externalUserid 外部联系人的userid，注意不是企业成员的帐号
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getExternalContactDetails(string $externalUserid)
    {
        return $this->httpGet('/cgi-bin/externalcontact/get', ['external_userid' => $externalUserid]);
    }

    /**
     * 修改客户备注信息
     * @param string $userId
     * @param string $externalUserid
     * @param array $config
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function setExternalContactRemark(string $userId, string $externalUserid, $config = [])
    {
        $data = array_merge([
            'userid' => $userId,
            'external_userid' => $externalUserid
        ], $config);
        $this->httpPostJson('/cgi-bin/externalcontact/remark', $data);
    }

    /**
     * 获取客户群列表
     * @param int $offset 分页，偏移量
     * @param int $limit 分页，预期请求的数据量，取值范围 1 ~ 1000
     * @param int $statusFilter 群状态过滤。
     * @param array $ownerFilter 群主过滤。如果不填，表示获取全部群主的数据
     * @param array $userIdList 用户ID列表。最多100个
     * @param array $partyIdList 部门ID列表。最多100个
     * @return void
     * @throws ArgumentException
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getGroupChatList(int $offset,
                                     int $limit,
                                     int $statusFilter = 0,
                                     array $ownerFilter = [],
                                     array $userIdList = [],
                                     array $partyIdList = [])
    {
        if ($offset < 0) throw new ArgumentException('偏移量不得小于0');
        if ($limit > 1000 || $limit < 0) throw new ArgumentException('预期请求的数据量不正确');
        if (count($userIdList) > 100) throw new ArgumentException('用户ID列表。最多100个');
        if (count($partyIdList) > 100) throw new ArgumentException('部门ID列表。最多100个');
        if (!in_array($statusFilter, [0, 1, 2, 3], true)) throw new ArgumentException('群状态过滤不正确');
        $data = [
            'offset' => $offset,
            'limit' => $limit,
            'status_filter' => $statusFilter,
            'owner_filter' => $ownerFilter,
            'userid_list' => $userIdList,
            'partyid_list' => $partyIdList
        ];
        return $this->httpPostJson('/cgi-bin/externalcontact/groupchat/list', $data);
    }

    /**
     * 获取客户群详情
     * @param string $chatId 客户群ID
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getGroupChatDetails(string $chatId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/groupchat/get', ['chat_id' => $chatId]);
    }

    /**
     * 获取离职成员的客户列表
     * @param int $pageId 分页查询，要查询页号，从0开始
     * @param int $pageSize 每次返回的最大记录数，默认为1000，最大值为1000
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getUnassignedList(int $pageId, int $pageSize)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/groupchat/get', ['page_id' => $pageId, 'page_size' => $pageSize]);
    }

    /**
     * 离职成员的外部联系人再分配
     * @param string $externalUserId 外部联系人的userid，注意不是企业成员的帐号
     * @param string $handoverUserId 离职成员的userid
     * @param string $takeoverUserId 接替成员的userid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function transferUnassigned(string $externalUserId, string $handoverUserId, string $takeoverUserId)
    {
        $data = ['external_userid' => $externalUserId, 'handover_userid' => $handoverUserId, 'takeover_userid' => $takeoverUserId];
        return $this->httpPostJson('/cgi-bin/externalcontact/transfer', $data);
    }

    /**
     * 离职成员的群再分配
     * @param array $chatIds 需要转群主的客户群ID列表。取值范围： 1 ~ 100
     * @param string $newOwner
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function transferGroupChat(array $chatIds, string $newOwner)
    {
        $data = ['chat_id_list' => $chatIds, 'new_owner' => $newOwner];
        return $this->httpPostJson('/cgi-bin/externalcontact/groupchat/transfer', $data);
    }

    /**
     *获取联系客户统计数据
     * @param array $userIds 用户ID列表
     * @param array $partyids 部门ID列表
     * @param int $startTime 数据起始时间
     * @param int $endTime 数据结束时间
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function behaviorData(array $userIds, array $partyids, int $startTime, int $endTime)
    {
        $data = [
            'userid' => $userIds,
            'partyid' => $partyids,
            'start_time' => $startTime,
            'end_time' => $endTime
        ];
        return $this->httpPostJson('/cgi-bin/externalcontact/get_user_behavior_data', $data);
    }

    /**
     * 获取客户群统计数据
     * @param int $beginTime 开始时间，填当天开始的0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天
     * @param int $offset 分页，偏移量, 默认为0
     * @param int $limit 分页，预期请求的数据量，默认为500，取值范围 1 ~ 1000
     * @param array $config ['owner_filter'=>[] ,'userid_list'=>[],'partyid_list'=>[],'order_by'=>1]
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function GroupChatStatistic(int $beginTime, int $offset, int $limit, array $config = [])
    {
        $data = array_merge(['day_begin_time' => $beginTime, 'offset' => $offset, 'limit' => $limit], $config);
        return $this->httpPostJson('/cgi-bin/externalcontact/groupchat/statistic', $data);
    }
}