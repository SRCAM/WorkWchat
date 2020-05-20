<?php


namespace WorkWechat\Actions;


use WorkWechat\Http\BaseRequest;

/**
 * 欢迎语素材
 * Class GroupWelcomeTemplate
 * @package WorkWechat\Actions
 */
class GroupWelcomeTemplate extends BaseRequest
{
    /**
     * 添加群欢迎语素材
     * @param $template
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function add($template)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/add', $template);
    }

    /**
     * @param string $templateId 欢迎语素材id
     * @param array $template 模板
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function edit(string $templateId, array $template)
    {
        $data = array_merge(['template_id' => $templateId], $template);
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/edit', $data);
    }

    /**
     * 获取群欢迎语素材
     * @param string $templateId 群欢迎语的素材id
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getDetails($templateId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/get', ['template_id' => $templateId]);
    }

    /**
     * 删除群欢迎语素材
     * @param string $templateId 群欢迎语的素材id
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delete(string $templateId)
    {
        return $this->httpPostJson('/cgi-bin/externalcontact/group_welcome_template/del', ['template_id' => $templateId]);
    }
}