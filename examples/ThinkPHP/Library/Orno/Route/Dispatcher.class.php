<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Route;

use FastRoute;
use FastRoute\Dispatcher\GroupCountBased as GroupCountBasedDispatcher;
use Orno\Di\ContainerInterface;
use Orno\Http\Exception as HttpException;
use Orno\Http\JsonResponse;
use Orno\Http\Response;
use Orno\Http\ResponseInterface;

class Dispatcher extends GroupCountBasedDispatcher implements RouteStrategyInterface
{
    /**
     * Route strategy functionality
     */
    use RouteStrategyTrait;

    /**
     * @var \Orno\Di\ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $routes;

    /**
     * Constructor
     *
     * @param array $routes
     * @param array $data
     */
    public function __construct(ContainerInterface $container, array $routes, array $data)
    {
        $this->container = $container;
        $this->routes    = $routes;
        parent::__construct($data);
    }

    /**
     * Match and dispatch a route matching the given http method and uri
     *
     * @param  string $method
     * @param  string $uri
     * @return \Orno\Http\ResponseInterface
     */
    public function dispatch($method, $uri)
    {
        $match = parent::dispatch($method, $uri);

        switch ($match[0]) {
//            0 404
            case FastRoute\Dispatcher::NOT_FOUND:
                $response = $this->handleNotFound();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowed  = (array) $match[1];
                $response = $this->handleNotAllowed($allowed);
                break;
            case FastRoute\Dispatcher::FOUND:
            default:
                $handler  = (isset($this->routes[$match[1]]['callback'])) ? $this->routes[$match[1]]['callback'] : $match[1];
                $strategy = $this->routes[$match[1]]['strategy'];
                $vars     = (array) $match[2];
                $response = $this->handleFound($handler, $strategy, $vars);
                break;
        }

        return $response;
    }

    /**
     * Handle dispatching of a found route
     *
     * @param  string|\Closure                             $handler
     * @param  integer|\Orno\Route\CustomStrategyInterface $strategy
     * @param  array                                       $vars
     * @return \Orno\Http\ResponseInterface
     * @throws RuntimeException
     */
    protected function handleFound($handler, $strategy, array $vars)
    {
        if (is_null($this->getStrategy())) {
            $this->setStrategy($strategy);
        }

        $controller = null;

        // figure out what the controller is
        if (($handler instanceof \Closure) || (is_string($handler) && is_callable($handler))) {
            $controller = $handler;
        }

        if (is_string($handler) && strpos($handler, '::') !== false) {
            $controller = explode('::', $handler);
        }

        // if controller method wasn't specified, throw exception.
        if (! $controller){
            throw new \RuntimeException('A class method must be provided as a controller. ClassName::methodName');
        }

        // handle getting of response based on strategy
        if (is_integer($strategy)) {
            switch ($strategy) {
                case RouteStrategyInterface::METHOD_ARGUMENT_STRATEGY:
                    $response = $this->handleMethodArgumentStrategy($controller, $vars);
                    break;
                case RouteStrategyInterface::URI_STRATEGY:
                    $response = $this->handleUriStrategy($controller, $vars);
                    break;
                case RouteStrategyInterface::RESTFUL_STRATEGY:
                    $response = $this->handleRestfulStrategy($controller, $vars);
                    break;
                case RouteStrategyInterface::REQUEST_RESPONSE_STRATEGY:
                default:
                    $response = $this->handleRequestResponseStrategy($controller, $vars);
                    break;
            // @codeCoverageIgnoreStart
            }
            // @codeCoverageIgnoreEnd

            return $response;
        }

        // we must be using a custom strategy
        return $strategy->dispatch($controller, $vars);
    }

    /**
     * Invoke a controller action
     *
     * @param  string|array|\Closure $controller
     * @param  array                 $vars
     * @return \Orno\Http\ResponseInterface
     */
    public function invokeController($controller, array $vars = [])
    {
        if (is_array($controller)) {
            $controller = [
                $this->container->get($controller[0]),
                $controller[1]
            ];
        }

        return call_user_func_array($controller, array_values($vars));

    }

    /**
     * Handles response to Request -> Response Strategy based routes
     *
     * @param  string|array|\Closure $controller
     * @param  array                 $vars
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleRequestResponseStrategy($controller, array $vars = [])
    {
        $response = $this->invokeController($controller, [
            $this->container->get('Orno\Http\Request'),
            $this->container->get('Orno\Http\Response'),
            $vars
        ]);

        if ($response instanceof ResponseInterface) {
            return $response;
        }

        throw new \RuntimeException(
            'When using the Request -> Response Strategy your controller must return an instance of [Orno\Http\ResponseInterface]'
        );
    }

    /**
     * Handles response to Restful Strategy based routes
     *
     * @param  string|array|\Closure $controller
     * @param  array                 $vars
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleRestfulStrategy($controller, array $vars = [])
    {
        try {
            $response = $this->invokeController($controller, [
                $this->container->get('Orno\Http\Request'),
                $vars
            ]);

            if ($response instanceof JsonResponse) {
                return $response;
            }

            if (is_array($response) || $response instanceof \ArrayObject) {
                return new JsonResponse($response);
            }

            throw new \RuntimeException(
                'Your controller action must return a valid response for the Restful Strategy. ' .
                'Acceptable responses are of type: [Array], [ArrayObject] and [Orno\Http\JsonResponse]'
            );
        } catch (HttpException $e) {
            return $e->getJsonResponse();
        }
    }

    /**
     * Handles response to URI Strategy based routes
     *
     * @param  string|array|\Closure $controller
     * @param  array                 $vars
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleUriStrategy($controller, array $vars)
    {
        $response = $this->invokeController($controller, $vars);

        return $this->determineResponse($response);
    }

    /**
     * Handles response to Method Argument Strategy
     *
     * @param  string|array|\Closure $controller
     * @param  array                 $vars
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleMethodArgumentStrategy($controller, array $vars)
    {
        if (is_array($controller)) {
            $controller = [
                $this->container->get($controller[0]),
                $controller[1]
            ];
        }

        $response = $this->container->call($controller);

        return $this->determineResponse($response);
    }

    /**
     * Attempt to build a response
     *
     * @param  mixed $response
     * @return \Orno\Http\ResponseInterface
     */
    protected function determineResponse($response)
    {
        if ($response instanceof ResponseInterface) {
            return $response;
        }

        try {
            $response = new Response($response);
        } catch (\Exception $e) {
            throw new \RuntimeException('Unable to build Response from controller return value', 0, $e);
        }

        return $response;
    }

    /**
     * Handle a not found route
     *
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleNotFound()
    {
        $exception = new HttpException\NotFoundException;

        if ($this->getStrategy() === RouteStrategyInterface::RESTFUL_STRATEGY) {
            return $exception->getJsonResponse();
        }

        throw $exception;
    }

    /**
     * Handles a not allowed route
     *
     * @param  array $allowed
     * @return \Orno\Http\ResponseInterface
     */
    protected function handleNotAllowed(array $allowed)
    {
        $exception = new HttpException\MethodNotAllowedException($allowed);

        if ($this->getStrategy() === RouteStrategyInterface::RESTFUL_STRATEGY) {
            return $exception->getJsonResponse();
        }

        throw $exception;
    }
}
