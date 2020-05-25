<?php


namespace WorkWechat\Core;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use WorkWechat\Core\Http\Response;
use WorkWechat\Core\Interfaces\AccessTokenInterface;
use WorkWechat\Core\Traits\HasHttpRequests;

/**
 * @mixin $t
 * Class BaseClient
 * @package WorkWechat\Core
 */
class BaseClient
{

    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var ServiceContainer
     */
    protected $app;
    /**
     * @var mixed|AccessTokenInterface
     */
    protected $accessToken;

    /**
     * @var string $baseUri
     */
    protected $baseUri;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * BaseClient constructor.
     * @param ServiceContainer $app
     * @param AccessTokenInterface $accessToken
     */
    public function __construct(ServiceContainer $app, AccessTokenInterface $accessToken)
    {
        $this->app = $app;
        $this->accessToken = $accessToken ?? $this->app['access_token'];
    }

    /**
     * GET 请求
     * @param string $url
     * @param array $query
     * @return ResponseInterface|void
     * @throws GuzzleException
     */
    public function requestGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', $query);
    }

    /**
     * post 请求
     * @param string $url
     * @param array $data
     * @return ResponseInterface|void
     * @throws GuzzleException
     */
    public function requestPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * post 请求
     * @param string $url
     * @param array $data
     * @param array $query
     * @return ResponseInterface|void
     * @throws GuzzleException
     */
    public function requestPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['json' => $data, 'query' => $query]);
    }



    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @param bool $returnRaw
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], bool $returnRaw = false)
    {
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }
        $response = $this->performRequest($url, $method, $options);

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    public function registerHttpMiddlewares()
    {
        // retry
        $this->pushMiddleware($this->retryMiddleware(), 'retry');
        // access token
        $this->pushMiddleware($this->accessTokenMiddleware(), 'access_token');
    }


    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return Response
     * @throws GuzzleException|GuzzleException
     */
    public function requestRaw(string $url, string $method = 'GET', array $options = [])
    {
        return Response::buildFromPsrResponse($this->request($url, $method, $options, true));
    }

    /**
     * 获取token
     */
    protected function accessTokenMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if ($this->accessToken) {
                    $request = $this->accessToken->applyToRequest($request, $options);
                }
                return $handler($request, $options);
            };
        };

    }

    /**
     * Return retry middleware.
     *
     * @return \Closure
     */
    protected function retryMiddleware()
    {
        return Middleware::retry(function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null
        ) {
            // Limit the number of retries to 2
            if ($retries < $this->app->config->get('http.max_retries', 1) && $response && $body = $response->getBody()) {
                // Retry on server errors
                $response = json_decode($body, true);

                if (!empty($response['errcode']) && in_array(abs($response['errcode']), [40001, 40014, 42001], true)) {
                    $this->accessToken->refresh();
                    $this->app['logger']->debug('Retrying with refreshed access token.');

                    return true;
                }
            }

            return false;
        }, function () {
            return abs($this->app->config->get('http.retry_delay', 500));
        });
    }

}