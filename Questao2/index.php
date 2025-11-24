<?php
// Função para carregar as tarefas do arquivo JSON
function carregarTarefas() {
    // Verifica se o arquivo existe
    if (file_exists('tarefas.json')) {
        $json = file_get_contents('tarefas.json');
        return json_decode($json, true); // Decodifica o JSON para um array associativo
    } else {
        return []; // Retorna um array vazio se o arquivo não existir
    }
}

// Função para salvar as tarefas no arquivo JSON
function salvarTarefas($tarefas) {
    $json = json_encode($tarefas, JSON_PRETTY_PRINT); // Converte o array para JSON
    file_put_contents('tarefas.json', $json); // Salva no arquivo
}

// Verifica se foi enviado o formulário para adicionar tarefa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $tarefas = carregarTarefas(); // Carrega as tarefas existentes

    // Adiciona a nova tarefa
    $tarefas[] = [
        'id' => uniqid(), // Gera um ID único para a tarefa
        'descricao' => $descricao,
        'status' => 'pendente'
    ];

    // Salva as tarefas no arquivo JSON
    salvarTarefas($tarefas);
}

// Verifica se uma tarefa deve ser excluída
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $tarefas = carregarTarefas(); // Carrega as tarefas existentes

    // Filtra as tarefas, removendo a tarefa com o ID especificado
    $tarefas = array_filter($tarefas, function($tarefa) use ($id) {
        return $tarefa['id'] !== $id;
    });

    // Re-indexa o array para corrigir os índices
    $tarefas = array_values($tarefas);

    // Salva as tarefas atualizadas
    salvarTarefas($tarefas);
}

// Verifica se uma tarefa deve ser concluída
if (isset($_GET['concluir'])) {
    $id = $_GET['concluir'];
    $tarefas = carregarTarefas(); // Carrega as tarefas existentes

    // Encontra a tarefa e marca como concluída
    foreach ($tarefas as &$tarefa) {
        if ($tarefa['id'] === $id) {
            $tarefa['status'] = 'concluída';
            break;
        }
    }

    // Salva as tarefas atualizadas
    salvarTarefas($tarefas);
}

// Carrega todas as tarefas
$tarefas = carregarTarefas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
</head>
<body>

<h1>Lista de Tarefas</h1>

<!-- Formulário para adicionar uma nova tarefa -->
<form action="index.php" method="POST">
    <label for="descricao">Descrição da Tarefa:</label>
    <input type="text" name="descricao" id="descricao" required>
    <input type="submit" value="Adicionar Tarefa">
</form>

<hr>

<!-- Exibir as tarefas -->
<h2>Tarefas</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($tarefas as $tarefa): ?>
        <tr>
            <td><?php echo $tarefa['id']; ?></td>
            <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
            <td><?php echo ucfirst($tarefa['status']); ?></td>
            <td>
                <?php if ($tarefa['status'] == 'pendente'): ?>
                    <a href="?concluir=<?php echo $tarefa['id']; ?>">Concluir</a>
                <?php endif; ?>
                <a href="?excluir=<?php echo $tarefa['id']; ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
