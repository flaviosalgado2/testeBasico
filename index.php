<?php
    require 'vendor/autoload.php';

    use Flaviosalgado\Testebasico\models\Pessoas;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pessoa = new Pessoas(
            $_POST['nome'],
            $_POST['telefone'],
            $_POST['id_cidade'],
            $_POST['id_estado']
        );

        $pessoa->salvar();

        header('Location: index.php');
        exit;
    }

    $resultPessoas = Pessoas::trazerTodas();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>

<body>

    <h1>Contatos</h1>

    <div>
        <form method="POST" action="">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone">
            </div>

            <div>
                <label for="id_cidade">ID Cidade:</label>
                <input type="number" id="id_cidade" name="id_cidade">
            </div>

            <div>
                <label for="id_estado">ID Estado:</label>
                <input type="number" id="id_estado" name="id_estado">
            </div>

            <button type="submit">Salvar</button>
        </form>
    </div>

    <div>

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