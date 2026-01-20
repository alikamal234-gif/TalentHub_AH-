<?php

namespace App;

use Core\Container\Container;
use Core\Trait\KernalTrait;

final class Kernal
{
    use KernalTrait;

    private string $projectDir;
    private Container $container;
    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
        $this->container = new Container();

        $this->container->bind('projectDir', $projectDir);
        $this->container->bind(__CLASS__, $this);
        $this->container->bind(Container::class, $this->container);
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }
}