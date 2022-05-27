<?php

namespace Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;
use PDO;


class PaginatedQuery implements AdapterInterface
{


    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private PDO $pdo,
        private string $query,
        private string $countQuery
    ) {
    }

    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice(int $offset, int $length): iterable
    {
        $statement = $this->pdo->prepare($this->query. ' LIMIT :offset, :length');
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':length', $length, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
