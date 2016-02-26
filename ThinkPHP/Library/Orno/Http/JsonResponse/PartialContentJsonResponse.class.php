<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http\JsonResponse;

use Orno\Http\JsonResponse;

class PartialContentJsonResponse extends JsonResponse
{
    /**
     * Constructor
     *
     * @param string|array $data
     * @param array        $headers
     */
    public function __construct($data = null, array $headers = [])
    {
        parent::__construct($data, 206, $headers);
    }
}
