<?php
    require 'vendor/autoload.php';

    use Flaviosalgado\Testebasico\models\Pessoas;

    $pessoaEditar = null;

    if (isset($_GET['editar'])) {
        $pessoaEditar = Pessoas::buscarPorId($_GET['editar']);
    }

    if (isset($_GET['excluir'])) {
        Pessoas::excluir($_GET['excluir']);
        header('Location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pessoa = new Pessoas(
            $_POST['nome'],
            $_POST['telefone'],
            $_POST['id_cidade'],
            $_POST['id_estado']
        );

        if (!empty($_POST['id'])) {
            $pessoa->atualizar($_POST['id']);
        } else {
            $pessoa->salvar();
        }

        header('Location: index.php');
        exit;
    }

    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $resultPessoas = Pessoas::buscar($_GET['busca']);
    } else {
        $resultPessoas = Pessoas::trazerTodas();
    }
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
            <input type="hidden" name="id" value="<?= $pessoaEditar ? $pessoaEditar['id'] : '' ?>">

            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= $pessoaEditar ? $pessoaEditar['nome'] : '' ?>" required>
            </div>

            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?= $pessoaEditar ? $pessoaEditar['telefone'] : '' ?>">
            </div>

            <div>
                <label for="id_cidade">ID Cidade:</label>
                <input type="number" id="id_cidade" name="id_cidade" value="<?= $pessoaEditar ? $pessoaEditar['id_cidade'] : '' ?>">
            </div>

            <div>
                <label for="id_estado">ID Estado:</label>
                <input type="number" id="id_estado" name="id_estado" value="<?= $pessoaEditar ? $pessoaEditar['id_estado'] : '' ?>">
            </div>

            <button type="submit">Salvar</button>
        </form>
    </div>

    <div>
        <h2>Buscar Contatos</h2>
        <form method="GET" action="">
            <div>
                <input type="text" id="busca" name="busca" placeholder="Nome, telefone, cidade ou estado" value="<?= isset($_GET['busca']) ? $_GET['busca'] : '' ?>">
                <button type="submit">Buscar</button>
                <a href="index.php">Limpar</a>
            </div>
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
                            <a href="?editar=<?= $pessoa['id'] ?>">Editar</a>
                            <a href="?excluir=<?= $pessoa['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este contato?');">Excluir</a>
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