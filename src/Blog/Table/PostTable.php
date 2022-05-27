<?php

namespace App\Blog\Table;

use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use PDO;
use stdClass;

class PostTable
{

    public function __construct(private PDO $pdo)
    {
    }

    /**
     * findPaginated
     *
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            "SELECT * FROM posts",
            "SELECT * COUNT(id) FROM posts"
        );
        return (new Pagerfanta($query))
                ->setMaxPerPage($perPage);
    }

    /**
     * find
     *
     * @param  int $id
     * @return stdClass
     */
    public function find(int $id): stdClass
    {
        $query = $this->pdo
            ->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
}
