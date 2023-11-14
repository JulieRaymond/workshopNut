<?php

namespace App\Model;

use PDO;

class NutManager extends AbstractManager
{
    const TABLE = 'nut';

    public function getAllStocks()
    {
        $query = "SELECT * FROM " . self::TABLE;
        $statement = $this->pdo->query($query);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function decrementStock(int $id)
    {
        $query = "UPDATE " . self::TABLE . " SET stock = stock - 1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id);
        $statement->execute();
    }
}
