<?php

namespace App\Repository;

use App\Entity\Role;
use App\Entity\User;
use Core\Database\Connection;
use Core\Repository\AbstractRepository;
use Core\Repository\SoftDeleteInterface;
use DateTimeImmutable;

class UserRepository extends AbstractRepository implements SoftDeleteInterface
{
    public function __construct(Connection $connection, string $tableName = 'users', string $alias = 'u')
    {
        parent::__construct($connection, $tableName, $alias);
    }

    public function find(int $id): ?User
    {
        $data = $this->createQueryBuilder()
            ->select('u.*', 'r.name AS role_name', 'r.created_at AS role_created_at', 'r.deleted_at AS role_deleted_at')
            ->innerJoin('roles', 'u.role_id = r.id', 'r')
            ->where('u.id = :id')
            ->andWhere('u.deleted_at IS NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        $data = $this->createQueryBuilder()
            ->select('u.*', 'r.name AS role_name', 'r.created_at AS role_created_at', 'r.deleted_at AS role_deleted_at')
            ->innerJoin('roles', 'u.role_id = r.id', 'r')
            ->where('u.deleted_at IS NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    public function findAllTrashed(): array
    {
        $data = $this->createQueryBuilder()
            ->select('u.*', 'r.name AS role_name', 'r.created_at AS role_created_at', 'r.deleted_at AS role_deleted_at')
            ->innerJoin('roles', 'u.role_id = r.id', 'r')
            ->where('u.deleted_at IS NOT NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    public function findByEmail(string $email): ?User
    {
        $data = $this->createQueryBuilder()
            ->select('u.*', 'r.name AS role_name', 'r.created_at AS role_created_at', 'r.deleted_at AS role_deleted_at')
            ->innerJoin('roles', 'u.role_id = r.id', 'r')
            ->where('u.email = :email')
            ->andWhere('u.deleted_at IS NULL')
            ->setParameter(':email', $email)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @param User $object
     * @return User
     */
    public function create(object $object): User
    {
        $stmt = $this->connection->getConnection()->prepare(
            "INSERT INTO {$this->tableName} (name, speciality, email, password, phone, image, created_at, role_id) VALUES (:name, :speciality, :email, :password, :phone, :image, :created_at, :role_id)"
        );

        $stmt->execute([
            ':name' => $object->getName(),
            ':speciality' => $object->getSpeciality(),
            ':email' => $object->getEmail(),
            ':password' => password_hash($object->getPassword(), PASSWORD_DEFAULT),
            ':phone' => $object->getPhone(),
            ':image' => $object->getImage(),
            ':created_at' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
            ':role_id' => $object->getRole()->getId(),
        ]);

        return $object->setId((int) $this->connection->getConnection()->lastInsertId());
    }

    public function update(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET name = :name, speciality = :speciality, email = :email, password = :password, phone = :phone, image = :image, role_id = :role_id WHERE id = :id"
        );

        $stmt->execute([
            ':name' => $object->getName(),
            ':speciality' => $object->getSpeciality(),
            ':email' => $object->getEmail(),
            ':password' => $object->getPassword(),
            ':phone' => $object->getPhone(),
            ':image' => $object->getImage(),
            ':role_id' => $object->getRole()->getId(),
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
     * @param User $object
     * @return object
     */
    public function restore(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET deleted_at = NULL WHERE id = :id"
        );

        $stmt->execute([
            ':id' => $object->getId(),
        ]);

        return $object
            ->setDeletedAt(null)
        ;
    }

    public function mapToObject(array $data): User
    {
        $role = new Role($data['role_name'])
            ->setId($data['role_id'])
        ;

        if (isset($data['role_created_at'])) {
            $role->setCreatedAt(new DateTimeImmutable($data['role_created_at']));
        }

        if (isset($data['role_deleted_at'])) {
            $role->setDeletedAt(new DateTimeImmutable($data['role_deleted_at']));
        }

        $user = new User($role, $data['name'], $data['email'], $data['password'])
            ->setId(isset($data['id']) ? (int) $data['id'] : null)
            ->setSpeciality($data['speciality'])
            ->setPhone($data['phone'])
            ->setImage($data['image'])
        ;

        if (isset($data['created_at'])) {
            $user->setCreatedAt(new DateTimeImmutable($data['created_at']));
        }

        if (isset($data['deleted_at'])) {
            $user->setDeletedAt(new DateTimeImmutable($data['deleted_at']));
        }

        return $user;
    }

    public function countUserByRole($role): int{
        return $this->createQueryBuilder()
        ->innerJoin("roles","r.id=u.role_id","r")
        ->where("r.name = :role")
        ->setParameter(":role",$role)
        ->getAffectedRows()
        ;
    }
}