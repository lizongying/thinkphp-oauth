<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http\Exception;

interface HttpExceptionInterface
{
    /**
     * Return the status code of the http exceptions
     *
     * @return integer
     */
    public function getStatusCode();

    /**
     * Return an array of headers provided when the exception was thrown
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Returns a response built from the thrown exception
     *
     * @return \Orno\Http\Response
     */
    public function getJsonResponse();
}
