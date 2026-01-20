<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;
use PDOException;

/**
 * Class Connection
 * 
 * Gère la connexion à la base de données MySQL via PDO.
 */
class Connection
{
    /**
     * @var PDO|null L'instance unique de PDO.
     */
    private ?PDO $instance = null;


    public function __construct(
        string $host = 'localhost',
        string $db = 'talent_hub',
        string $user = 'root',
        string $pass = '',
        string $charset = 'utf8mb4'
    ) {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->instance ??= new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }


    /**
     * Empêche le clonage de l'instance.
     */
    public function getConnection(): ?PDO
    {
        return $this->instance;
    }
}
