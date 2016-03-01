<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

use Symfony\Component\HttpFoundation;

class Response extends HttpFoundation\Response implements ResponseInterface
{
    /**
     * Parameter encapsulation
     */
    use ResponseParameterTrait;
}
