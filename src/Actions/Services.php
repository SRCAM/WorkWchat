<?php


namespace WorkWechat\Actions;


use WorkWechat\Http\BaseRequest;

class Services extends BaseRequest
{

    /**
     * 添加企业群发消息任务
     * @param array $template 模板信息
     * @param string $chatType 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     * @param string $sender 发送企业群发消息的成员userid，当类型为发送给客户群时必填
     * @param array $externalUserid 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function addCorpMsgTemplate(array $template, string $chatType = 'single', string $sender = null, array $externalUserid = [])
    {
        $data = array_merge([
            'sender' => $sender,
            'external_userid' => $externalUserid,
            'chat_type' => $chatType
        ], $template);
        return $this->httpPostJson('/cgi-bin/externalcontact/add_msg_template', $data);
    }

    /**
     * 获取企业群发消息发送结果
     * @param string $msgId 群发消息的id，通过添加企业群发消息模板接口返回
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getGroupMsgResult(string $msgId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/get_group_msg_result', ['msgid' => $msgId]);
    }

    /**
     * 发送新客户欢迎语
     * @param string $welcomeCode 通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒
     * @param array $template 主题
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function sendWelcomeMsg(string $welcomeCode, array $template)
    {
        $data = array_merge(['welcome_code' => $welcomeCode], $template);
        return $this->httpPostJson('/cgi-bin/externalcontact/send_welcome_msg', $data);
    }
    
}