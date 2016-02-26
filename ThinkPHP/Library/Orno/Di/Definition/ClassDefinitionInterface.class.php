<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Di\Definition;

interface ClassDefinitionInterface extends DefinitionInterface
{
    /**
     * Add a method to be invoked
     *
     * @param  string $method
     * @param  array  $args
     * @return \Orno\Di\Definition\ClassDefinitionInterface
     */
    public function withMethodCall($method, array $args = []);

    /**
     * Add multiple methods to be invoked
     *
     * @param  array $methods
     * @return \Orno\Di\Definition\ClassDefinitionInterface
     */
    public function withMethodCalls(array $methods = []);
}
