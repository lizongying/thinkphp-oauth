<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Route;

interface RouteStrategyInterface
{
    /**
     * Types of route strategies
     */
    const REQUEST_RESPONSE_STRATEGY = 0;
    const RESTFUL_STRATEGY          = 1;
    const URI_STRATEGY              = 2;
    const METHOD_ARGUMENT_STRATEGY  = 3;

    /**
     * Tells the implementor which strategy to use, this should override any higher
     * level setting of strategies, such as on specific routes
     *
     * @param  integer $strategy
     * @return void
     */
    public function setStrategy($strategy);

    /**
     * Gets global strategy
     *
     * @return integer
     */
    public function getStrategy();
}
