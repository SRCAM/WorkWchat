<?php


namespace WorkWechat\Work;


use WorkWechat\Http\BaseRequest;

/**
 * 批量处理
 * Class Batch
 * @package WorkWechat\Ebs
 */
class Batch extends BaseRequest
{
    /**
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function invite($data)
    {
        return $this->HttpPost('/cgi-bin/batch/invite', $data);
    }

    /**
     * 增量更新成员
     * @param string $media_id 上传的csv文件的media_id
     * @param array $callback 回调信息。如填写该项则任务完成后
     * 具体参数请见 https://work.weixin.qq.com/api/doc/90000/90135/90982
     * @param bool $toInvite 是否邀请新建的成员使用企业微信
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function syncuser(string $media_id, array $callback = [], bool $toInvite = true)
    {
        $data = [
            'media_id' => $media_id,
            'callback' => $callback,
            'to_invite' => $toInvite
        ];
        return $this->httpPostJson('/cgi-bin/batch/syncuser', $data);
    }

    /**
     * 全量覆盖成员
     * @param string $media_id 上传的csv文件的media_id
     * @param array $callback 回调信息。如填写该项则任务完成后
     * 具体参数请见 https://work.weixin.qq.com/api/doc/90000/90135/90982
     * @param bool $toInvite 是否邀请新建的成员使用企业微信
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function replaceUser(string $media_id, array $callback = [], bool $toInvite = true)
    {
        $data = [
            'media_id' => $media_id,
            'callback' => $callback,
            'to_invite' => $toInvite
        ];
        return $this->httpPostJson('/cgi-bin/batch/replaceuser', $data);
    }

    /**
     * 全量覆盖部门
     * @param string $media_id 上传的csv文件的media_id
     * @param array $callback 回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
     * 具体参数请见 https://work.weixin.qq.com/api/doc/90000/90135/90982
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function replaceParty(string $media_id, array $callback = [])
    {
        $data = [
            'media_id' => $media_id,
            'callback' => $callback,
        ];
        return $this->HttpPost('/cgi-bin/batch/replaceparty', $data);
    }

    /**
     * 获取异步任务结果
     * @param $jobid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getresult($jobid)
    {
        return $this->httpGet('/cgi-bin/batch/getresult', ['jobid'=>$jobid]);
    }

    /**
     * 获取客户详情
     * @param $externalUserid
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function get($externalUserid)
    {
        $query['external_userid'] = $externalUserid;
            return $this->HttpGet('/cgi-bin/batch/getresult', $query);
    }

    /**
     * 修改客户备注信息
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function remark($data)
    {
        return $this->HttpGet('/cgi-bin/externalcontact/remark', $data);
    }

    /**
     * 获取企业标签库
     * @param $tagIds
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getCorpTagList($tagIds)
    {
        $data['tag_id'] = $tagIds;
        return $this->HttpPost('/cgi-bin/externalcontact/get_corp_tag_list', $data);
    }

    /**
     * 编辑客户企业标签
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function markTag($data)
    {
        return $this->HttpPost('/cgi-bin/externalcontact/mark_tag', $data);
    }

    /**
     * 获取客户群详情
     * @param $chatId
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function groupChatGet($chatId)
    {
        $data['chat_id'] = $chatId;
        return $this->HttpPost('/cgi-bin/externalcontact/groupchat/get', $data);
    }

    /**
     * 发送新客户欢迎语
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function sendWelcomeMsg($data)
    {
        return $this->HttpPost('/cgi-bin/externalcontact/send_welcome_msg', $data);
    }

    /**
     * 添加企业群发消息任务
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function addMsgTemplate($data)
    {
        return $this->HttpPost('/cgi-bin/externalcontact/add_msg_template', $data);
    }

    /**
     * 获取企业群发消息发送结果
     * @param string $msgId 群发消息的id，通过添加企业群发消息模板接口返回
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getGroupMsgResult($msgId)
    {
        $data['msgid'] = $msgId;
        return $this->HttpPost('/cgi-bin/externalcontact/add_msg_template', $data);
    }

    /**
     * 获取离职成员的客户列表
     * @param int $page_id
     * @param int $page_size
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getUnassignedList($page_id = 0, $page_size = 1000)
    {
        $data = [
            'page_id' => $page_id,
            'page_size' => $page_size
        ];
        return $this->HttpPost('/cgi-bin/externalcontact/get_unassigned_list', $data);
    }

    /**
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function externalContactTransfe($data)
    {
        return $this->HttpPost('/cgi-bin/externalcontact/transfer', $data);
    }

    /**
     * 获取联系客户统计数据
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getUserBehaviorData($data)
    {
        return $this->HttpPost('/cgi-bin/externalcontact/get_user_behavior_data', $data);
    }
}