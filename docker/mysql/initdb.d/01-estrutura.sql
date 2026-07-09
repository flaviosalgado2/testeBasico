CREATE TABLE IF NOT EXISTS estado (
    id INT PRIMARY KEY,
    nome VARCHAR(75),
    uf VARCHAR(2),
    ibge INT,
    pais INT,
    ddd VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS cidade (
    id INT PRIMARY KEY,
    nome VARCHAR(120),
    uf INT,
    ibge INT,
    FOREIGN KEY (uf) REFERENCES estado(id)
);

CREATE TABLE IF NOT EXISTS pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(50),
    id_cidade INT,
    id_estado INT,
    FOREIGN KEY (id_cidade) REFERENCES cidade(id),
    FOREIGN KEY (id_estado) REFERENCES estado(id)
);
