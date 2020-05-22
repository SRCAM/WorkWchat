<?php


namespace WorkWechat\Core\Http;

use \GuzzleHttp\Psr7\Response as PsrResponse;
use Psr\Http\Message\ResponseInterface;
use WorkWechat\Core\Collection;
use WorkWechat\Core\Support\XML;

class Response extends PsrResponse
{
    public function getBodyContents()
    {
        $this->getBody()->rewind();
        $contents = $this->getBody()->getContents();
        $this->getBody()->rewind();
        return $contents;
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    public static function buildFromPsrResponse(ResponseInterface $response)
    {
        return new static(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }

    public function toJson()
    {
        return json_decode($this->toArray());
    }


    /**
     * Build to array.
     *
     * @return array
     */
    public function toArray()
    {
        $content = $this->removeControlCharacters($this->getBodyContents());

        if (false !== stripos($this->getHeaderLine('Content-Type'), 'xml') || 0 === stripos($content, '<xml')) {
            return Xml::parse($content);
        }
        $array = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
        if (JSON_ERROR_NONE === json_last_error()) {
            return (array)$array;
        }
        return [];
    }

    /**
     * @param string $content
     *
     * @return string
     */
    protected function removeControlCharacters(string $content)
    {
        return \preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', $content);
    }

    /**
     * 转为对象
     * @return mixed
     */
    public function toObject()
    {
        return json_decode($this->toJson());
    }

    public function toCollection()
    {
        return new Collection($this->toArray());
    }

    /**
     * 获取字符串
     * @return string
     */
    public function __toString()
    {
        return $this->getBodyContents();
    }

}