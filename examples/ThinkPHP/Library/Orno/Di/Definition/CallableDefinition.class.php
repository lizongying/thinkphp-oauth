<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Di\Definition;

use Orno\Di\ContainerInterface;

class CallableDefinition extends AbstractDefinition implements DefinitionInterface
{

    /**
     * @var callable
     */
    protected $callable;

    /**
     * Constructor
     *
     * @param string                      $alias
     * @param callable                    $concrete
     * @param \Orno\Di\ContainerInterface $container
     */
    public function __construct($alias, callable $concrete, ContainerInterface $container)
    {
        parent::__construct($alias, $container);

        $this->callable = $concrete;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(array $args = [])
    {
        $resolved = $this->resolveArguments($args);

        return call_user_func_array($this->callable, $resolved);
    }
}
