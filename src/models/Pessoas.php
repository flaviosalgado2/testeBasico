<?php

namespace Flaviosalgado\Testebasico\models;

use Flaviosalgado\Testebasico\DB;

class Pessoas extends DB
{
    private $nome;
    private $telefone;
    private $idCidade;
    private $idEstado;

    public function __construct($nome, $telefone, $idCidade, $idEstado)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->idCidade = $idCidade;
        $this->idEstado = $idEstado;
    }

    public function salvar()
    {
        $conn = DB::getConn();
        $stmt = $conn->prepare("INSERT INTO pessoas (nome, telefone, id_cidade, id_estado) VALUES (:nome, :telefone, :id_cidade, :id_estado)");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':id_cidade', $this->idCidade);
        $stmt->bindParam(':id_estado', $this->idEstado);
        return $stmt->execute();
    }

    public static function criarTabelaSeNaoExistir()
    {
        $conn = DB::getConn();
        $sql = "CREATE TABLE IF NOT EXISTS pessoas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            telefone VARCHAR(50),
            id_cidade INT,
            id_estado INT
        )";
        $conn->exec($sql);
    }

    public static function criarRegistrosIniciaisSeVazio()
    {
        $conn = DB::getConn();
        $stmt = $conn->query("SELECT COUNT(*) as total FROM pessoas");
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado['total'] == 0) {
            $contatos = [
                ['João Silva', '(11) 98765-4321', 1, 1],
                ['Maria Souza', '(21) 99876-5432', 2, 2],
                ['Pedro Oliveira', '(31) 91234-5678', 3, 3],
                ['Ana Costa', '(41) 92345-6789', 4, 4],
                ['Carlos Santos', '(51) 93456-7890', 5, 5],
            ];

            foreach ($contatos as $contato) {
                $pessoa = new self($contato[0], $contato[1], $contato[2], $contato[3]);
                $pessoa->salvar();
            }
        }
    }

    public static function trazerTodas()
    {
        $conn = DB::getConn();

        self::criarTabelaSeNaoExistir();
        self::criarRegistrosIniciaisSeVazio();
        
        $stmt = $conn->query("SELECT * FROM pessoas");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}