<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http\Exception;

use Orno\Http\Exception as HttpException;

class MethodNotAllowedException extends HttpException
{
    /**
     * Constructor
     *
     * @param string     $message
     * @param \Exception $previous
     * @param integer    $code
     */
    public function __construct(array $allowed = [], $message = 'Method Not Allowed', \Exception $previous = null, $code = 0)
    {
        $headers = [
            'Allow' => implode(', ', $allowed)
        ];

        parent::__construct(405, $message, $previous, $headers, $code);
    }
}
