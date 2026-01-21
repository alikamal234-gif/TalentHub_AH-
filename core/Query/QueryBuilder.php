<?php

namespace Core\Query;

use PDO;
use PDOStatement;

/**
 * DQL Query Builder
 */
class QueryBuilder
{
    public const string JOIN_INNER = 'INNER';
    public const string JOIN_LEFT = 'LEFT';
    public const string JOIN_RIGHT = 'RIGHT';

    private PDO $pdo;

    private QueryCompile $compile;

    private array $selects = ['*'];

    private string $from = '';

    private array $joins = [];

    private array $wheres = [];

    private array $parameters = [];

    private ?int $limit = null;

    private ?int $offset = null;

    private array $orderBy = [];

    private array $groups = [];

    private array $havings = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->compile = new QueryCompile();
    }

    /**
     * Définit les champs à sélectionner.
     *
     * @param string ...$fields Les noms des champs ou expressions SQL.
     * @return self
     */
    public function select(string ...$fields): self
    {
        $this->selects = $fields;
        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->from = $alias ? "$table AS $alias" : $table;
        return $this;
    }

    public function join(string $table, string $condition, string $type = self::JOIN_INNER, ?string $alias = null): self
    {
        $joinedTable = $alias ? "$table AS $alias" : $table;
        $this->joins[] = "$type JOIN $joinedTable ON $condition";
        return $this;
    }

    public function leftJoin(string $table, string $condition, ?string $alias = null): self
    {
        return $this->join($table, $condition, self::JOIN_LEFT, $alias);
    }

    public function innerJoin(string $table, string $condition, ?string $alias = null): self
    {
        return $this->join($table, $condition, self::JOIN_INNER, $alias);
    }

    public function rightJoin(string $table, string $condition, ?string $alias = null): self
    {
        return $this->join($table, $condition, self::JOIN_RIGHT, $alias);
    }

    public function where(string $condition): self
    {
        return $this->andWhere($condition);
    }

    public function andWhere(string $condition): self
    {
        $this->wheres[] = ['type' => 'AND', 'condition' => $condition];
        return $this;
    }

    public function orWhere(string $condition): self
    {
        $this->wheres[] = ['type' => 'OR', 'condition' => $condition];
        return $this;
    }

    public function setParameter(string $key, mixed $value): self
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    public function setParameters(array $parameters): self
    {
        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }
        return $this;
    }

    public function orderBy(string $sort, string $order = 'ASC'): self
    {
        $this->orderBy[] = "$sort $order";
        return $this;
    }

    public function groupBy(string ...$fields): self
    {
        $this->groups = array_merge($this->groups, $fields);
        return $this;
    }

    public function having(string $condition): self
    {
        return $this->andHaving($condition);
    }

    public function andHaving(string $condition): self
    {
        $this->havings[] = ['type' => 'AND', 'condition' => $condition];
        return $this;
    }

    public function orHaving(string $condition): self
    {
        $this->havings[] = ['type' => 'OR', 'condition' => $condition];
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function getQuery(): string
    {
        return $this->compile->compileSelect(
            $this->selects,
            $this->from,
            $this->joins,
            $this->wheres,
            $this->groups,
            $this->havings,
            $this->orderBy,
            $this->limit,
            $this->offset
        );
    }

    public function statement(): PDOStatement
    {
        $sql = $this->getQuery();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->parameters);
        return $stmt;
    }

    public function getResult(): array
    {
        return $this->statement()->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSingleResult(): ?array
    {
        $result = $this->statement()->fetch(\PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getAffectedRows(): int
    {
        return $this->statement()->rowCount();
    }

    public function reset(): self
    {
        $this->selects = ['*'];
        $this->from = '';
        $this->joins = [];
        $this->wheres = [];
        $this->parameters = [];
        $this->limit = null;
        $this->offset = null;
        $this->orderBy = [];
        $this->groups = [];
        $this->havings = [];
        return $this;
    }
}