<?php


namespace WorkWechat\Core\Traits;


use http\Client\Response;
use Psr\Http\Message\ResponseInterface;
use think\contract\Arrayable;
use WorkWechat\Core\Interfaces\Model;

trait ResponseCastable
{
    /**
     *
     * @param ResponseInterface $response
     * @param null $type
     * @param Model|null $model
     * @return void
     */
    protected function castResponseToType(ResponseInterface $response, $type = null, Model $model = null)
    {
        $response = \WorkWechat\Core\Http\Response::buildFromPsrResponse($response);
        $response->getBody()->rewind();
        switch ($type ?? 'array') {
            case 'collection':
                return $response->toCollection();
            case 'array':
                return $response->toArray();
            case 'object':
                return $response->toObject();
            case 'raw':
                return $response;
            default:
                if (!is_subclass_of($type, Arrayable::class)) {
//                   an instanceof %s', Arrayable::class));
                    //todo: 抛出错误
                }
                return new $type($response);
        }
    }

    /**
     * @param $response
     * @param null $type
     */
    public function detectAndCastResponseToType($response, $type = null)
    {
        switch (true) {
            case $response instanceof ResponseInterface:
                $response = Response::buildFromPsrResponse($response);

                break;
            case $response instanceof Arrayable:
                $response = new Response(200, [], json_encode($response->toArray()));

                break;
            case ($response instanceof Collection) || is_array($response) || is_object($response):
                $response = new Response(200, [], json_encode($response));

                break;
            case is_scalar($response):
                $response = new Response(200, [], (string)$response);

                break;
            default:
                throw new InvalidArgumentException(sprintf('Unsupported response type "%s"', gettype($response)));
        }
        $this->castResponseToType($response, $type);
    }
}