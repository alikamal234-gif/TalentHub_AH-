<?php

namespace Core\Repository;


use Core\Database\Connection;
use Core\Query\QueryBuilder;

abstract class AbstractRepository
{
    protected Connection $connection;
    protected string $tableName;
    protected string $alias;

    public function __construct(Connection $connection, string $tableName, string $alias)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->alias = $alias;
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->connection->getConnection())
            ->select('*')
            ->from($this->tableName, $this->alias)
            ;
    }

    abstract public function find(int $id): ?object;
    abstract public function findAll(): array;
    abstract public function create(object $object): object;
    abstract public function update(object $object): object;
    abstract public function delete(object $object): bool;
    abstract public function mapToObject(array $data): object;
}