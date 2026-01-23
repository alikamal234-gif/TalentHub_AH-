<?php

namespace App\Repository;

use App\Entity\Tag;
use Core\Database\Connection;
use Core\Repository\AbstractRepository;
use Core\Repository\SoftDeleteInterface;
use DateTimeImmutable;

class TagRepository extends AbstractRepository implements SoftDeleteInterface
{
    public function __construct(Connection $connection, string $tableName = 'tags', string $alias = 't')
    {
        parent::__construct($connection, $tableName, $alias);
    }

    public function find(int $id): ?Tag
    {
        $data = $this->createQueryBuilder()
            ->select('t.*')
            ->where('t.id = :id')
            ->andWhere('t.deleted_at IS NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @return Tag[]
     */
    public function findAll(): array
    {
        $data = $this->createQueryBuilder()
            ->select('t.*')
            ->where('t.deleted_at IS NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    public function findAllTrashed(): array
    {
        $data = $this->createQueryBuilder()
            ->select('t.*')
            ->where('t.deleted_at IS NOT NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @param Tag $object
     * @return Tag
     */
    public function create(object $object): Tag
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

    public function findTrashed(int $id): ?Tag
    {
        $data = $this->createQueryBuilder()
            ->select('t.*')
            ->where('t.id = :id')
            ->andWhere('t.deleted_at IS NOT NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;
        

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @param Tag $object
     * @return Tag
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
     * @param Tag $object
     * @return Tag
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

    public function mapToObject(array $data): Tag
    {
        $tag = new Tag($data['name']);
        $tag->setId(isset($data['id']) ? (int) $data['id'] : null);

        if (isset($data['created_at'])) {
            $tag->setCreatedAt(new DateTimeImmutable($data['created_at']));
        }

        if (isset($data['deleted_at'])) {
            $tag->setDeletedAt(new DateTimeImmutable($data['deleted_at']));
        }

        return $tag;
    }
    public function save(object $object): Tag
    {
        if ($object->getId()) {
            return $this->update($object);
        }
        return $this->create($object);
    }
}
