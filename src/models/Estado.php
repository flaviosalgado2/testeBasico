<?php

namespace Flaviosalgado\Testebasico\models;

use Flaviosalgado\Testebasico\DB;

class Estado extends DB
{
    public static function trazerTodos(): array
    {
        $conn = DB::getConn();
        $stmt = $conn->query("SELECT * FROM estado ORDER BY nome");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(int $id): ?array
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("SELECT * FROM estado WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }
}
