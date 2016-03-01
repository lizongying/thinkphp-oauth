<?php

namespace Orno\Di;

interface ContainerAwareInterface
{
    /**
     * Set a container
     *
     * @param \Orno\Di\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container);

    /**
     * Get the container
     *
     * @return \Orno\Di\ContainerInterface
     */
    public function getContainer();
}
