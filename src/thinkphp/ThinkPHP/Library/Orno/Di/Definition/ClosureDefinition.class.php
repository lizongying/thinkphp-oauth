<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Di\Definition;

use Orno\Di\ContainerInterface;
use Orno\Di\Exception;

class ClosureDefinition extends AbstractDefinition implements DefinitionInterface
{
    /**
     * @var \Closure
     */
    protected $closure;

    /**
     * Constructor
     *
     * @param string                      $alias
     * @param \Closure                    $closure
     * @param \Orno\Di\ContainerInterface $container
     */
    public function __construct($alias, \Closure $closure, ContainerInterface $container)
    {
        parent::__construct($alias, $container);

        $this->closure = $closure;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(array $args = [])
    {
        return call_user_func_array($this->closure, $this->resolveArguments($args));
    }
}
