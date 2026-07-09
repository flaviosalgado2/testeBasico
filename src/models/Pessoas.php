<?php

namespace Flaviosalgado\Testebasico\models;

use Flaviosalgado\Testebasico\DB;

class Pessoas extends DB
{
    private string $nome;
    private string $telefone;
    private int $idCidade;
    private int $idEstado;

    public function __construct(string $nome, string $telefone, int $idCidade, int $idEstado)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->idCidade = $idCidade;
        $this->idEstado = $idEstado;
    }

    public function salvar(): bool
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("INSERT INTO pessoas (nome, telefone, id_cidade, id_estado) VALUES (:nome, :telefone, :id_cidade, :id_estado)");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':id_cidade', $this->idCidade, \PDO::PARAM_INT);
        $stmt->bindParam(':id_estado', $this->idEstado, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar(string $id): bool
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("UPDATE pessoas SET nome = :nome, telefone = :telefone, id_cidade = :id_cidade, id_estado = :id_estado WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':id_cidade', $this->idCidade, \PDO::PARAM_INT);
        $stmt->bindParam(':id_estado', $this->idEstado, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function buscarPorId(string $id): array
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("SELECT p.*, c.nome as cidade_nome, e.nome as estado_nome, e.uf as estado_uf
                                FROM pessoas p
                                LEFT JOIN cidade c ON p.id_cidade = c.id
                                LEFT JOIN estado e ON p.id_estado = e.id
                                WHERE p.id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function trazerTodas(): array
    {
        $conn = DB::getConn();
        $stmt = $conn->query("SELECT p.*, c.nome as cidade_nome, e.nome as estado_nome, e.uf as estado_uf
                              FROM pessoas p
                              LEFT JOIN cidade c ON p.id_cidade = c.id
                              LEFT JOIN estado e ON p.id_estado = e.id
                              ORDER BY p.nome");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function buscar(string $termo): array
    {
        $conn = DB::getConn();

        $sql = "SELECT p.*, c.nome as cidade_nome, e.nome as estado_nome, e.uf as estado_uf
                FROM pessoas p
                LEFT JOIN cidade c ON p.id_cidade = c.id
                LEFT JOIN estado e ON p.id_estado = e.id
                WHERE p.nome LIKE :termo
                    OR p.telefone LIKE :termo
                    OR c.nome LIKE :termo
                    OR e.nome LIKE :termo
                    OR e.uf LIKE :termo";

        $stmt = $conn->prepare($sql);
        $termoBusca = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoBusca);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function excluir(string $id): bool
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("DELETE FROM pessoas WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
