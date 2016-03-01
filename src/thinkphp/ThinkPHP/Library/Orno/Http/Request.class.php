<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

use Symfony\Component\HttpFoundation;

class Request extends HttpFoundation\Request implements RequestInterface
{
    /**
     * Parameter encapsulation
     */
    use RequestParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function uriSegment($index, $default = null)
    {
        $uri      = trim($this->getPathInfo(), '/');
        $segments = explode('/', $uri);

        return (isset($segments[$index - 1])) ? $segments[$index - 1] : $default;
    }
}
