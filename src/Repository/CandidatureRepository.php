<?php

namespace App\Repository;

use App\Entity\Candidature;
use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Categorie;
use Core\Database\Connection;
use Core\Repository\AbstractRepository;
use DateTimeImmutable;

class CandidatureRepository extends AbstractRepository
{
    public function __construct(Connection $connection, string $tableName = 'candidatures', string $alias = 'can')
    {
        parent::__construct($connection, $tableName, $alias);
    }

    public function find(int $id): ?Candidature
    {
        $data = $this->createQueryBuilder()
            ->select(
                'can.*',
                'u.name AS user_name',
                'u.email AS user_email',
                'u.password AS user_password',
                'u.speciality AS user_speciality',
                'u.phone AS user_phone',
                'u.image AS user_image',
                'u.created_at AS user_created_at',
                'u.deleted_at AS user_deleted_at',
                'u.role_id AS user_role_id',
                'o.name AS offer_name',
                'o.description AS offer_description',
                'o.salary AS offer_salary',
                'o.city AS offer_city',
                'o.contact AS offer_contact',
                'o.company AS offer_company',
                'o.created_at AS offer_created_at',
                'o.deleted_at AS offer_deleted_at',
                'o.category_id AS offer_category_id',
                'o.owner_id AS offer_owner_id'
            )
            ->innerJoin('users', 'can.user_id = u.id', 'u')
            ->innerJoin('offers', 'can.offer_id = o.id', 'o')
            ->where('can.id = :id')
            ->setParameter(':id', $id)
            ->getSingleResult()
        ;

        if (!$data) {
            return null;
        }

        return $this->mapToObject($data);
    }

    /**
     * @return Candidature[]
     */
    public function findAll(): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'can.*',
                'u.name AS user_name',
                'u.email AS user_email',
                'u.password AS user_password',
                'u.speciality AS user_speciality',
                'u.phone AS user_phone',
                'u.image AS user_image',
                'u.created_at AS user_created_at',
                'u.deleted_at AS user_deleted_at',
                'u.role_id AS user_role_id',
                'o.name AS offer_name',
                'o.description AS offer_description',
                'o.salary AS offer_salary',
                'o.city AS offer_city',
                'o.contact AS offer_contact',
                'o.company AS offer_company',
                'o.created_at AS offer_created_at',
                'o.deleted_at AS offer_deleted_at',
                'o.category_id AS offer_category_id',
                'o.owner_id AS offer_owner_id'
            )
            ->innerJoin('users', 'can.user_id = u.id', 'u')
            ->innerJoin('offers', 'can.offer_id = o.id', 'o')
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @return Candidature[]
     */
    public function findAllByOffer(Offer $offer): array
    {
        $data = $this->createQueryBuilder()
            ->select(
                'can.*',
                'u.name AS user_name',
                'u.email AS user_email',
                'u.password AS user_password',
                'u.speciality AS user_speciality',
                'u.phone AS user_phone',
                'u.image AS user_image',
                'u.created_at AS user_created_at',
                'u.deleted_at AS user_deleted_at',
                'u.role_id AS user_role_id',
                'o.name AS offer_name',
                'o.description AS offer_description',
                'o.salary AS offer_salary',
                'o.city AS offer_city',
                'o.contact AS offer_contact',
                'o.company AS offer_company',
                'o.created_at AS offer_created_at',
                'o.deleted_at AS offer_deleted_at',
                'o.category_id AS offer_category_id',
                'o.owner_id AS offer_owner_id'
            )
            ->innerJoin('users', 'can.user_id = u.id', 'u')
            ->innerJoin('offers', 'can.offer_id = o.id', 'o')
            ->where('can.offer_id = :offer_id')
            ->setParameter(':offer_id', $offer->getId())
            ->getResult()
        ;

        return array_map(fn($data) => $this->mapToObject($data), $data);
    }

    /**
     * @param Candidature $candidature
     */
    public function save(Candidature $candidature): void
    {
        if ($candidature->getId()) {
            $this->update($candidature);
        } else {
            $this->create($candidature);
        }
    }

    /**
     * @param Candidature $object
     * @return Candidature
     */
    public function create(object $object): Candidature
    {
        $stmt = $this->connection->getConnection()->prepare(
            "INSERT INTO {$this->tableName} (user_id, offer_id, message, cv, status, created_at) 
             VALUES (:user_id, :offer_id, :message, :cv, :status, :created_at)"
        );

        $stmt->execute([
            ':user_id' => $object->getUser()->getId(),
            ':offer_id' => $object->getOffer()->getId(),
            ':message' => $object->getMessage(),
            ':cv' => $object->getCv(),
            ':status' => $object->getStatus(),
            ':created_at' => $object->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        return $object->setId((int) $this->connection->getConnection()->lastInsertId());
    }

    /**
     * @param Candidature $object
     * @return Candidature
     */
    public function update(object $object): object
    {
        $stmt = $this->connection->getConnection()->prepare(
            "UPDATE {$this->tableName} SET 
                user_id = :user_id, 
                offer_id = :offer_id, 
                message = :message, 
                cv = :cv, 
                status = :status 
             WHERE id = :id"
        );

        $stmt->execute([
            ':user_id' => $object->getUser()->getId(),
            ':offer_id' => $object->getOffer()->getId(),
            ':message' => $object->getMessage(),
            ':cv' => $object->getCv(),
            ':status' => $object->getStatus(),
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

    public function mapToObject(array $data): Candidature
    {
        // Hydrate User (Applicant)
        $role = new Role('Unknown')->setId((int) $data['user_role_id']);
        $user = new User($role, $data['user_name'], $data['user_email'], $data['user_password']);
        $user->setId((int) $data['user_id']);
        $user->setSpeciality($data['user_speciality']);
        $user->setPhone($data['user_phone']);
        $user->setImage($data['user_image']);
        if (isset($data['user_created_at'])) {
            $user->setCreatedAt(new DateTimeImmutable($data['user_created_at']));
        }
        if (isset($data['user_deleted_at']) && $data['user_deleted_at'] !== null) {
            $user->setDeletedAt(new DateTimeImmutable($data['user_deleted_at']));
        }

        $offerOwner = new User(new Role('Unknown'), 'Unknown', 'Unknown', 'Unknown')->setId((int) $data['offer_owner_id']);
        $offerCategory = null;
        if (isset($data['offer_category_id'])) {
            $offerCategory = new Categorie('Unknown')->setId((int) $data['offer_category_id']);
        }

        $offer = new Offer(
            $offerCategory,
            $offerOwner,
            $data['offer_name'],
            $data['offer_description'],
            (float) $data['offer_salary'],
            $data['offer_city'],
            $data['offer_contact'],
            $data['offer_company']
        );
        $offer->setId((int) $data['offer_id']);
        if (isset($data['offer_created_at'])) {
            $offer->setCreatedAt(new DateTimeImmutable($data['offer_created_at']));
        }
        if (isset($data['offer_deleted_at']) && $data['offer_deleted_at'] !== null) {
            $offer->setDeletedAt(new DateTimeImmutable($data['offer_deleted_at']));
        }

        $candidature = new Candidature($user, $offer, $data['message']);
        $candidature->setId(isset($data['id']) ? (int) $data['id'] : null);
        $candidature->setCv($data['cv']);
        $candidature->setStatus($data['status']);

        if (isset($data['created_at'])) {
            $candidature->setCreatedAt(new DateTimeImmutable($data['created_at']));
        }

        return $candidature;
    }
}
