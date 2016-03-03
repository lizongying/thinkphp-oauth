<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Route;

trait RouteStrategyTrait
{
    /**
     * @var \Orno\Route\CustomStrategyInterface|integer
     */
    protected $strategy;

    /**
     * Tells the implementor which strategy to use, this should override any higher
     * level setting of strategies, such as on specific routes
     *
     * @param  integer|\Orno\Route\CustomStrategyInterface $strategy
     * @return void
     */
    public function setStrategy($strategy)
    {
        if (is_integer($strategy) || $strategy instanceof CustomStrategyInterface) {
            $this->strategy = $strategy;

            return null;
        }

        throw new \InvalidArgumentException(
            'Provided strategy must be an integer or an instance of [\Orno\Route\CustomStrategyInterface]'
        );
    }

    /**
     * Gets global strategy
     *
     * @return integer
     */
    public function getStrategy()
    {
        return $this->strategy;
    }
}
