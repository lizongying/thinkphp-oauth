<?php
namespace Home\Controller;
use Think\Controller;
use League\OAuth2\Server\ResourceServer;
use League\Route\Http\Exception\NotFoundException;
use Orno\Http\Request;
use Orno\Http\Response;
class ApiController extends Controller {

//    路由
    private $__router;

//    服务器
    private $__server;

//    请求
    private $__request;

    function __construct()
    {
        parent::__construct();

//        设置资源服务器
        $sessionStorage = new \Home\Storage\SessionStorage();
        $accessTokenStorage = new \Home\Storage\AccessTokenStorage();
        $clientStorage = new \Home\Storage\ClientStorage();
        $scopeStorage = new \Home\Storage\ScopeStorage();

        $this->__server = new ResourceServer(
            $sessionStorage,
            $accessTokenStorage,
            $clientStorage,
            $scopeStorage
        );

//        路由设置
        $this->__request = (new Request())->createFromGlobals();
        $this->__router = new \Orno\Route\RouteCollection();
    }

    /**
     * 默认首页
     */
    public function index()
    {

    }

    /**
     * 获取资源
     */
    private function __getSource()
    {
        $server = $this->__server;
        $router = $this->__router;
        $request = $this->__request;

        $dispatcher = $router->getDispatcher();

        try {
            // Check that access token is present
//            验证是否有效访问
            $server->isValidRequest(false);
            // A successful response
//            请求成功
            $response = $dispatcher->dispatch(
                $request->getMethod(),
                $request->getPathInfo()
            );

        } catch (\Orno\Http\Exception $e) {
            // A failed response
            $response = $e->getJsonResponse();
            $response->setContent(json_encode(['status_code' => $e->getStatusCode(), 'message' => $e->getMessage()]));
        } catch (\League\OAuth2\Server\Exception\OAuthException $e) {
            $response = new Response(json_encode([
                'error'     =>  $e->errorType,
                'message'   =>  $e->getMessage(),
            ]), $e->httpStatusCode);

            foreach ($e->getHttpHeaders() as $header) {
                $response->headers($header);
            }
        } catch (\Exception $e) {
            $response = new Response();
            $response->setStatusCode(500);
            $response->setContent(json_encode(['status_code' => 500, 'message' => $e->getMessage()]));
        } finally {
            // Return the response
            $response->headers->set('Content-type', 'application/json');
            $response->send();
        }
    }

    /**
     * 令牌信息
     */
    public function tokeninfo()
    {
        $server = $this->__server;
        $router = $this->__router;
        $request = $this->__request;

//        获取令牌信息
        $router->get('/home/api/tokeninfo', function (Request $request) use ($server) {
            $accessToken = $server->getAccessToken();
            $session = $server->getSessionStorage()->getByAccessToken($accessToken);
            $token = [
                'owner_id' => $session->getOwnerId(),
                'owner_type' => $session->getOwnerType(),
                'access_token' => $accessToken,
                'client_id' => $session->getClient()->getId(),
                'scopes' => $accessToken->getScopes(),
            ];

            return new Response(json_encode($token));

        });
        $this->__getSource();
    }

    /**
     * 用户信息
     */
    public function users()
    {
        $server = $this->__server;
        $router = $this->__router;
        $request = $this->__request;

        if ($_SERVER['REDIRECT_URL'] === '/home/api/users')
        {

//        获取用户信息
            $router->get('/home/api/users', function (Request $request) use ($server) {

                $results = D('Users')->select();
                $users = [];
                foreach ($results as $result) {
                    $user = [
                        'username'  =>  $result['username'],
                        'name'      =>  $result['name'],
                    ];

                    if ($server->getAccessToken()->hasScope('email')) {
                        $user['email'] = $result['email'];
                    }

                    if ($server->getAccessToken()->hasScope('photo')) {
                        $user['photo'] = $result['photo'];
                    }

                    $users[] = $user;
                }

                return new Response(json_encode($users));
            });
        }
        else
        {;

            //        获取用户信息
            $router->get($_SERVER['REDIRECT_URL'], function (Request $request, Response $response, array $args) use ($server) {
//                $result = D('Users')->select($args['username']);
                $result = D('Users')->select(end(explode('/', $_SERVER['REDIRECT_URL'])));
                if (count($result) === 0) {
                    throw new NotFoundException();
                }

                $user = [
                    'username'  =>  $result[0]['username'],
                    'name'      =>  $result[0]['name'],
                ];

                if ($server->getAccessToken()->hasScope('email')) {
                    $user['email'] = $result[0]['email'];
                }

                if ($server->getAccessToken()->hasScope('photo')) {
                    $user['photo'] = $result[0]['photo'];
                }

                return new Response(json_encode($user));
            });

        }

        $this->__getSource();
    }

}