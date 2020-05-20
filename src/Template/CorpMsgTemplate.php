<?php

namespace WorkWechat\Template;

/**
 * Class CorpMsgTemplate
 */
class CorpMsgTemplate extends Template
{

    public $text;  //消息文本内容
    private $image;  //图片
    private $link; //图文消息标题
    private $miniprogram; //小程序消息

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return mixed
     */
    public function getMiniprogram()
    {
        return $this->miniprogram;
    }


}