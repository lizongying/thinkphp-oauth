<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http\JsonResponse;

use Orno\Http\JsonResponse;

class ResetContentJsonResponse extends JsonResponse
{
    /**
     * Constructor
     *
     * @param array $headers
     */
    public function __construct(array $headers = [])
    {
        parent::__construct('', 205, $headers);
    }
}
