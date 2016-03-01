<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

interface ResponseInterface
{
    /**
     * Send HTTP headers and body
     *
     * @return \Orno\Http\ResponseInterface
     */
    public function send();
}
