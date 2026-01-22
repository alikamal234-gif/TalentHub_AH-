<?php

namespace App\Repository;

use App\Entity\Categorie;
use Core\Database\Connection;
use Core\Repository\AbstractRepository;
use Core\Repository\SoftDeleteInterface;
use DateTimeImmutable;

class CategorieRepository extends AbstractRepository implements SoftDeleteInterface
{
    public function __construct(Connection $connection, string $tableName = 'categories', string $alias = 'c')
    {
        parent::__construct($connection, $tableName, $alias);
    }

    public function find(int $id): ?Categorie
    {
        $data = $this->createQueryBuilder()
            ->select('c.*')
            ->where('c.id = :id')
            ->andWhere('c.deleted_at IS NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @return Categorie[]
     */
    public function findAll(): array
    {
        $data = $this->createQueryBuilder()
            ->select('c.*')
            ->where('c.deleted_at IS NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    public function findAllTrashed(): array
    {
        $data = $this->createQueryBuilder()
            ->select('c.*')
            ->where('c.deleted_at IS NOT NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @param Categorie $object
     * @return Categorie
     */
    public function create(object $object): Categorie
    {
        $stmt = $this->connection->getConnection()->prepare(
            "INSERT INTO {$this->tableName} (name, created_at) VALUES (:name, :created_at)"
        );

        $stmt->execute([
            ':name' => $object->getName(),
            ':created_at' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        return $object->setId((int) $this->connection->getConnection()->lastInsertId());
    }

    /**
     * @param Categorie $object
     * @return Categorie
     */
    public function update(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET name = :name WHERE id = :id"
        );

        $stmt->execute([
            ':name' => $object->getName(),
            ':id' => $object->getId(),
        ]);

        return $object;
    }

    public function delete(object $object): bool
    {
        $stmt = $this->connection->getConnection()->prepare(
            "DELETE FROM {$this->tableName} WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $object->getId(),
        ]);
    }

    public function trashed(object $object): bool
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET deleted_at = :deleted_at WHERE id = :id"
        );

        return $stmt->execute([
            ':deleted_at' => new \DateTime()->format('Y-m-d H:i:s'),
            ':id' => $object->getId(),
        ]);
    }

    /**
     * @param Categorie $object
     * @return Categorie
     */
    public function restore(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET deleted_at = NULL WHERE id = :id"
        );

        $stmt->execute([
            ':id' => $object->getId(),
        ]);

        return $object->setDeletedAt(null);
    }

    public function mapToObject(array $data): Categorie
    {
        $categorie = new Categorie($data['name']);
        $categorie->setId(isset($data['id']) ? (int) $data['id'] : null);

        if (isset($data['created_at'])) {
            $categorie->setCreatedAt(new DateTimeImmutable($data['created_at']));
        }

        if (isset($data['deleted_at']) && $data['deleted_at'] !== null) {
            $categorie->setDeletedAt(new DateTimeImmutable($data['deleted_at']));
        }

        return $categorie;
    }
}
