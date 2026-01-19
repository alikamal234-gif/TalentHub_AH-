<?php

namespace Core\Repository;


use Core\Database\Connection;

abstract class AbstractRepository
{
    protected \PDO $pdo;
    protected string $tableName;
    public function __construct(Connection $connection, string $tableName)
    {
        $this->pdo = $connection->getConnection();
        $this->tableName = $tableName;
    }

    protected function findAll(): array
    {
        return $this->pdo->query("SELECT * FROM {$this->tableName}")->fetchAll();
    }
    protected function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    abstract public function mapToObject(array $data);
}