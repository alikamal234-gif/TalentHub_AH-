<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Tag;
use Core\Database\Connection;
use Core\Repository\AbstractRepository;
use Core\Repository\SoftDeleteInterface;
use DateTimeImmutable;

class OfferRepository extends AbstractRepository implements SoftDeleteInterface
{
    public function __construct(Connection $connection, string $tableName = 'offers', string $alias = 'o')
    {
        parent::__construct($connection, $tableName, $alias);
    }

    public function findTrashed(int $id): ?Offer
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.id = :id')
            ->andWhere('o.deleted_at IS NOT NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    public function find(int $id): ?Offer
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.id = :id')
            ->andWhere('o.deleted_at IS NULL')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @return Offer[]
     */
    public function findAll(): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.deleted_at IS NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @return Offer[]
     */
    public function findAllByOwner(User $user): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.deleted_at IS NULL')
            ->andWhere('o.owner_id = :owner_id')
            ->setParameter(':owner_id', $user->getId())
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @return Offer[]
     */
    public function findAllTrashed(): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.deleted_at IS NOT NULL')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @return Offer[]
     */
    public function findAllTrashedByOwner(User $user): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'o.*',
                'c.name AS category_name',
                'c.created_at AS category_created_at',
                'c.deleted_at AS category_deleted_at',
                'u.name AS owner_name',
                'u.email AS owner_email',
                'u.password AS owner_password',
                'u.speciality AS owner_speciality',
                'u.phone AS owner_phone',
                'u.image AS owner_image',
                'u.created_at AS owner_created_at',
                'u.deleted_at AS owner_deleted_at',
                'u.role_id AS owner_role_id'
            )
            ->leftJoin('categories', 'o.category_id = c.id', 'c')
            ->innerJoin('users', 'o.owner_id = u.id', 'u')
            ->where('o.deleted_at IS NOT NULL')
            ->andWhere('o.owner_id = :owner_id')
            ->setParameter(':owner_id', $user->getId())
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @param Offer $object
     * @return Offer
     */
    public function save(object $object): Offer
    {
        if ($object->getId()) {
            return $this->update($object);
        }
        return $this->create($object);
    }

    /**
     * @param Offer $object
     * @return Offer
     */
    public function create(object $object): Offer
    {
        $stmt = $this->connection->getConnection()->prepare(
            "INSERT INTO {$this->tableName} (category_id, owner_id, name, description, salary, city, contact, company, created_at) 
             VALUES (:category_id, :owner_id, :name, :description, :salary, :city, :contact, :company, :created_at)"
        );

        $stmt->execute([
            ':category_id' => $object->getCategory() ? $object->getCategory()->getId() : null,
            ':owner_id' => $object->getOwner()->getId(),
            ':name' => $object->getName(),
            ':description' => $object->getDescription(),
            ':salary' => $object->getSalary(),
            ':city' => $object->getCity(),
            ':contact' => $object->getContact(),
            ':company' => $object->getCompany(),
            ':created_at' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        return $object->setId((int) $this->connection->getConnection()->lastInsertId());
    }

    /**
     * @param Offer $object
     * @return Offer
     */
    public function update(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET 
                category_id = :category_id, 
                owner_id = :owner_id, 
                name = :name, 
                description = :description, 
                salary = :salary, 
                city = :city, 
                contact = :contact, 
                company = :company 
             WHERE id = :id"
        );

        $stmt->execute([
            ':category_id' => $object->getCategory() ? $object->getCategory()->getId() : null,
            ':owner_id' => $object->getOwner()->getId(),
            ':name' => $object->getName(),
            ':description' => $object->getDescription(),
            ':salary' => $object->getSalary(),
            ':city' => $object->getCity(),
            ':contact' => $object->getContact(),
            ':company' => $object->getCompany(),
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
     * @param Offer $object
     * @return Offer
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

    public function findTagsByOffer(int $offerId): array
    {
        $stmt = $this->connection->getConnection()->prepare(
            "SELECT t.* FROM tags t 
             JOIN offer_tag ot ON t.id = ot.tag_id 
             WHERE ot.offer_id = :offer_id AND t.deleted_at IS NULL"
        );
        $stmt->execute([':offer_id' => $offerId]);
        $data = $stmt->fetchAll();

        $tagRepo = new TagRepository($this->connection);
        return array_map(fn($item) => $tagRepo->mapToObject($item), $data);
    }

    public function syncTags(int $offerId, array $tagIds): void
    {
        // Remove old tags
        $stmt = $this->connection->getConnection()->prepare(
            "DELETE FROM offer_tag WHERE offer_id = :offer_id"
        );
        $stmt->execute([':offer_id' => $offerId]);

        // Add new tags
        if (!empty($tagIds)) {
            $sql = "INSERT INTO offer_tag (offer_id, tag_id) VALUES ";
            $values = [];
            $params = [];
            foreach ($tagIds as $index => $tagId) {
                $values[] = "(:offer_id_$index, :tag_id_$index)";
                $params[":tag_id_$index"] = (int) $tagId;
                $params[":offer_id_$index"] = $offerId;
            }
            $sql .= implode(', ', $values);

            $stmt = $this->connection->getConnection()->prepare($sql);
            $stmt->execute($params);
        }
    }

    public function mapToObject(array $data): Offer
    {
        $category = null;
        if (isset($data['category_id']) && $data['category_id'] !== null) {
            $category = new Categorie($data['category_name']);
            $category->setId((int) $data['category_id']);
            if (isset($data['category_created_at'])) {
                $category->setCreatedAt(new DateTimeImmutable($data['category_created_at']));
            }
            if (isset($data['category_deleted_at'])) {
                $category->setDeletedAt(new DateTimeImmutable($data['category_deleted_at']));
            }
        }

        $role = new Role('Unknown')->setId((int) $data['owner_role_id']);

        $owner = new User($role, $data['owner_name'], $data['owner_email'], $data['owner_password']);
        $owner->setId((int) $data['owner_id']);
        $owner->setSpeciality($data['owner_speciality']);
        $owner->setPhone($data['owner_phone']);
        $owner->setImage($data['owner_image']);
        if (isset($data['owner_created_at'])) {
            $owner->setCreatedAt(new DateTimeImmutable($data['owner_created_at']));
        }
        if (isset($data['owner_deleted_at'])) {
            $owner->setDeletedAt(new DateTimeImmutable($data['owner_deleted_at']));
        }

        $offer = new Offer(
            $category,
            $owner,
            $data['name'],
            $data['description'],
            (float) $data['salary'],
            $data['city'],
            $data['contact'],
            $data['company']
        );
        $offer->setId(isset($data['id']) ? (int) $data['id'] : null);

        if (isset($data['created_at'])) {
            $offer->setCreatedAt(new DateTimeImmutable($data['created_at']));
        }

        if (isset($data['deleted_at'])) {
            $offer->setDeletedAt(new DateTimeImmutable($data['deleted_at']));
        }

        $offer->setTags($this->findTagsByOffer($offer->getId() ?? 0));

        return $offer;
    }
}
