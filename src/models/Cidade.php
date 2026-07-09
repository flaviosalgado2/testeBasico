<?php

namespace Flaviosalgado\Testebasico\models;

use Flaviosalgado\Testebasico\DB;

class Cidade extends DB
{
    public static function trazerTodas(): array
    {
        $conn = DB::getConn();
        $stmt = $conn->query("SELECT * FROM cidade ORDER BY nome");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function trazerPorEstado(int $idEstado): array
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("SELECT * FROM cidade WHERE uf = :id_estado ORDER BY nome");
        $stmt->bindParam(':id_estado', $idEstado, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(int $id): ?array
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("SELECT * FROM cidade WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }
}
