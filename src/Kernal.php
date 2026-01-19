<?php

namespace App;

use Core\Container\Container;
use Core\Trait\KernalTrait;

final class Kernal
{
    use KernalTrait;

    private Container $container;
    public function __construct()
    {
        $this->container = new Container();
        $this->container->bind(__CLASS__, $this);
        $this->container->bind(Container::class, $this->container);
    }
}