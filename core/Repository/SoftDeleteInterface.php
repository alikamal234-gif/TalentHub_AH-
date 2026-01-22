<?php

namespace Core\Repository;

interface SoftDeleteInterface
{
    public function trashed(object $object): bool;
    public function restore(object $object): object;
}