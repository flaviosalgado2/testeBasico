<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>

<body>

    <?php
        require 'vendor/autoload.php';
    ?>

    <nav>
        <div>
            <a href="#">Agenda</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/">Início</a></li>
                <li><a href="/pessoa/criar">Novo Contato</a></li>
            </ul>
        </div>
    </nav>

    <?php

        use Flaviosalgado\Testebasico\models\Pessoas;

        $resultPessoas = Pessoas::trazerTodas();
    ?>      

    <div>
        
        <h1>Contatos</h1>
        <h2>Listagem de Contatos</h2>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>ID Cidade</th>
                    <th>ID Estado</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultPessoas as $pessoa) : ?>
                    <tr>
                        <td><?= $pessoa['id'] ?></td>
                        <td><?= $pessoa['nome'] ?></td>
                        <td><?= $pessoa['telefone'] ?></td>
                        <td><?= $pessoa['id_cidade'] ?></td>
                        <td><?= $pessoa['id_estado'] ?></td>
                        <td>
                            <a href="">Editar</a>
                            <a href="">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>

    </script>

</body>
</html>