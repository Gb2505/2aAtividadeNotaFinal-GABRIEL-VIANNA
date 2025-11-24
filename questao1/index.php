<?php
// Função para carregar os livros do arquivo JSON
function carregarLivros() {
    $livros = file_get_contents('livros.json');
    return json_decode($livros, true);
}

$livros = carregarLivros();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Biblioteca</h1>
    
    <a href="cadastrar_livro.php">Cadastrar Novo Livro</a> | 
    <a href="emprestar_livro.php">Emprestar Livro</a>

    <h2>Lista de Livros</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Disponível</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livros as $livro): ?>
            <tr>
                <td><?php echo $livro['id']; ?></td>
                <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                <td><?php echo $livro['disponivel'] ? 'Sim' : 'Não'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
