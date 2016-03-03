<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http;

trait RequestParameterTrait
{
    /**
     * Return array or single key from $_GET
     *
     * @param  string $key
     * @return mixed
     */
    public function query($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->query;
        }

        return $this->query->get($key, $default);
    }

    /**
     * Return array or single key from $_POST
     *
     * @param  string $key
     * @return mixed
     */
    public function post($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->request;
        }

        return $this->request->get($key, $default);
    }

    /**
     * Return array or single key from $_SERVER
     *
     * @param  string $key
     * @return mixed
     */
    public function server($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->server;
        }

        return $this->server->get($key, $default);
    }

    /**
     * Return array or single key from $_FILES
     *
     * @param  string $key
     * @return mixed
     */
    public function files($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->files;
        }

        return $this->files->get($key, $default);
    }

    /**
     * Return array or single key from $_COOKIE
     *
     * @param  string $key
     * @return mixed
     */
    public function cookie($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->cookies;
        }

        return $this->cookies->get($key, $default);
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
