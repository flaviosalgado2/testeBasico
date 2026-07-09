<?php
    require 'vendor/autoload.php';

    use Flaviosalgado\Testebasico\models\Pessoas;
    use Flaviosalgado\Testebasico\models\Estado;
    use Flaviosalgado\Testebasico\models\Cidade;

    if (isset($_GET['ajax']) && $_GET['ajax'] === 'cidades' && isset($_GET['estado'])) {
        header('Content-Type: application/json');
        echo json_encode(Cidade::trazerPorEstado((int) $_GET['estado']));
        exit;
    }

    $pessoaEditar = null;
    $estadoSelecionado = '';
    $cidadeSelecionada = '';

    if (isset($_GET['editar'])) {
        $pessoaEditar = Pessoas::buscarPorId($_GET['editar']);
        if ($pessoaEditar) {
            $cidadeSelecionada = $pessoaEditar['id_cidade'] ?? '';
            $estadoSelecionado = $pessoaEditar['id_estado'] ?? '';
        }
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
            (int) $_POST['id_cidade'],
            (int) $_POST['id_estado']
        );

        if (!empty($_POST['id'])) {
            $pessoa->atualizar($_POST['id']);
        } else {
            $pessoa->salvar();
        }

        header('Location: index.php');
        exit;
    }

    $estados = Estado::trazerTodos();

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
    <style>
        .logo-supremo {
            background-color: #0A2342;
            padding: 40px;
            border-radius: 8px;
            display: block;
            margin-bottom: 20px;
        }

        form div {
            margin-bottom: 10px;
        }

        label {
            display: inline-block;
            width: 120px;
        }

        select, input[type="text"] {
            padding: 5px;
            min-width: 250px;
        }
    </style>
</head>

<body>

    <img src="https://supremocrm.com.br/wp-content/uploads/2020/11/logo-supremo-branco.png" class="logo-supremo">

    <h1>Agenda de Contatos</h1>

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
                <label for="id_estado">Estado:</label>
                <select id="id_estado" name="id_estado" required onchange="carregarCidades(this.value)">
                    <option value="">Selecione um estado</option>
                    <?php foreach ($estados as $estado) : ?>
                        <option value="<?= $estado['id'] ?>" <?= $estado['id'] == $estadoSelecionado ? 'selected' : '' ?>>
                            <?= $estado['nome'] ?> (<?= $estado['uf'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="id_cidade">Cidade:</label>
                <select id="id_cidade" name="id_cidade" required>
                    <option value="">Selecione um estado primeiro</option>
                </select>
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
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultPessoas as $pessoa) : ?>
                    <tr>
                        <td><?= $pessoa['id'] ?></td>
                        <td><?= $pessoa['nome'] ?></td>
                        <td><?= $pessoa['telefone'] ?></td>
                        <td><?= $pessoa['cidade_nome'] ?? '' ?></td>
                        <td><?= ($pessoa['estado_nome'] ?? '') . ($pessoa['estado_uf'] ? ' (' . $pessoa['estado_uf'] . ')' : '') ?></td>
                        <td>
                            <a href="?editar=<?= $pessoa['id'] ?>">Editar</a>
                            <a href="?excluir=<?= $pessoa['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este contato?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div>
            <h3>Descrição:</h3>
            <p>Teste Básico para a Vaga "Desenvolvedor PHP - Remoto PJ" na Empresa Supremo CRM para Imobiliárias (Edbraulio Vieira - Diretor de Tecnologia, Full Cycle Developer)</p>
            <p>TAREFA: Criar um CRUD de cadastro de um de Agenda de Contatos, com os campos: Nome, Telefone, 
                Cidade, Estado. Crie as tabelas no MySQL. Faça em PHP Puro. <br>Preciso também de uma pesquisa, 
                na tela de listar, para nome, telefone, cidade (em texto) e estado(em texto). Após fazer a tarefa, 
                publique ela em seu Github e me envie o link.
            </p>
            <p>RECOMENDAÇÃO: Não use IA nesse momento, quero ver a sua lógica. Se você usar IA neste teste, 
                será desclassificado(a).
            </p>
            <p>APRESENTAÇÃO: Após isso, vamos fazer uma entrevista, via google meet, para você me apresentar 
                e fazer alterações aovivo no projeto.
            </p>
        </div>
    </div>

    <script>
        const selectEstado = document.getElementById('id_estado');
        const selectCidade = document.getElementById('id_cidade');
        const cidadeSelecionada = '<?= $cidadeSelecionada ?>';

        async function carregarCidades(estadoId, selecionada = '') {
            if (!estadoId) return;

            const cidades = await fetch('index.php?ajax=cidades&estado=' + estadoId).then(r => r.json());

            selectCidade.innerHTML = '<option value="">Selecione uma cidade</option>' +
                cidades.map(cidade => `<option value="${cidade.id}" ${cidade.id == selecionada ? 'selected' : ''}>${cidade.nome}</option>`).join('');
        }

        // para o modo editar
        if (selectEstado.value) {
            carregarCidades(selectEstado.value, cidadeSelecionada);
        }
    </script>

</body>
</html>