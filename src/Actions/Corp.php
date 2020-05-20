<?php


namespace WorkWechat\Actions;


use WorkWechat\Exception\ArgumentException;
use WorkWechat\Http\BaseRequest;

/**
 * 企业相关
 * Class Corp
 * @package WorkWechat\Actions\
 */
class Corp extends BaseRequest
{

    /**
     * 获取加入企业二维码
     * @param int $sizeType
     * @throws ArgumentException
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function getJoinQrcode(int $sizeType = 1)
    {
        if (!in_array($sizeType, [1, 2, 3, 4], true)) {
            throw new ArgumentException('参数错误');
        }
        return $this->httpGet('/cgi-bin/corp/get_join_qrcode', ['size_type' => $sizeType]);
    }

    /**
     * 获取企业标签库
     * @param array $tagIds 要查询的标签id
     * @return void
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws \WorkWechat\Exception\NotfindException
     */
    public function getTagList(array $tagIds)
    {
        return $this->httpPost('/cgi-bin/externalcontact/get_corp_tag_list', ['tag_id' => $tagIds]);
    }


    /**
     * 添加企业客户标签
     * @param array $tag 标签名称
     * @param string $groupId 标签组id
     * @param string $groupName 标签组名称
     * @param int|null $order 标签组次序值
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws ArgumentException
     * @deprecated 如果要向指定的标签组下添加标签，需要填写group_id参数；如果要创建一个全新的标签组以及标签，则需要通过group_name参数指定新标签组名称，如果填写的
     * groupname已经存在，则会在此标签组下新建标签。
     * 如果填写了group_id参数，则group_name和标签组的order参数会被忽略。
     * 不支持创建空标签组。
     * 标签组内的标签不可同名，如果传入多个同名标签，则只会创建一个。
     */
    public function addTag(array $tag, string $groupId = null, string $groupName = null, int $order = 0)
    {
        if (strlen($groupName > 30)) {
            throw new ArgumentException('标签组名称，最长为30个字符');
        }
        if ($order < 0) {
            throw new ArgumentException('有效的值范围是[0, 2^32)');
        }
        $data = array(
            'group_id' => $groupId,
            'group_name' => $groupName,
            'order' => $order,
            'tag' => $tag
        );
        return $this->httpPostJson('/cgi-bin/externalcontact/add_corp_tag', $data);
    }

    /**
     * 编辑企业客户标签
     * @param string $id 标签或标签组的id列表
     * @param string $name 新的标签或标签组名称，最长为30个字符
     * @param int $order 标签/标签组的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * @return void
     * @throws ArgumentException
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function editTag(string $id, string $name, int $order = null)
    {
        if (strlen($name > 100)) {
            throw new ArgumentException('标签组名称，最长为30个字符');
        }
        $data = [
            'id' => $id,
            'name' => $name,
            'order' => $order
        ];
        return $this->httpPostJson('/cgi-bin/externalcontact/edit_corp_tag', $data);
    }

    /**
     * 删除企业客户标签
     * 企业可通过此接口删除客户标签库中的标签，或删除整个标签组。
     * @param array $tagIds 标签的id列表
     * @param array $groupIds 标签组的id列表
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delTag(array $tagIds = [], array $groupIds = [])
    {
        $data = [
            'tag_id' => $tagIds,
            'group_id' => $groupIds
        ];
        return $this->httpPostJson('/cgi-bin/externalcontact/del_corp_tag', $data);
    }

    /**
     * 编辑客户企业标签
     * @param string $userid 添加外部联系人的userid
     * @param string $externalUsers 外部联系人userid
     * @param array $addTag 要标记的标签列表
     * @param array $removeTag 要移除的标签列表
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function markTag(string $userid, string $externalUsers, array $addTag = [], array $removeTag = [])
    {
        $data = [
            'userid' => $userid,
            'external_userid' => $externalUsers,
            'add_tag' => $addTag,
            'remove_tag' => $removeTag
        ];
        return $this->httpPostJson('/cgi-bin/externalcontact/mark_tag', $data);
    }
}