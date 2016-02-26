<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

trait ResponseParameterTrait
{
    /**
     * Return array or single key from $_COOKIE
     *
     * @param  string $key
     * @return mixed
     */
    public function cookie($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->headers->getCookies();
        }

        return (isset($this->headers->getCookies()[$key])) ? $this->headers->getCookies()[$key] : $default;
    }

    /**
     * Return array or single key from headers taken from $_SERVER
     *
     * @param  string $key
     * @return mixed
     */
    public function headers($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->headers;
        }

        return $this->headers->get($key, $default);
    }
}
