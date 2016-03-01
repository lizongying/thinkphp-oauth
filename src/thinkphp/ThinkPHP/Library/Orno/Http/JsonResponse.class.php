<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

use Symfony\Component\HttpFoundation;

class JsonResponse extends HttpFoundation\JsonResponse implements ResponseInterface
{
    /**
     * Parameter encapsulation
     */
    use ResponseParameterTrait;
}
