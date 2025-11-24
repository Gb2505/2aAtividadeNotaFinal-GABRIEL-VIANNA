<?php
// Função para salvar os livros no arquivo JSON
function salvarLivros($livros) {
    file_put_contents('livros.json', json_encode($livros, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livros = json_decode(file_get_contents('livros.json'), true);

    // Obtém o ID do livro a ser emprestado
    $idLivro = $_POST['id'];

    // Encontra o livro e altera o status de disponibilidade
    foreach ($livros as &$livro) {
        if ($livro['id'] == $idLivro && $livro['disponivel']) {
            $livro['disponivel'] = false;
            break;
        }
    }

    // Salva os livros no arquivo
    salvarLivros($livros);

    echo "<p>Livro emprestado com sucesso!</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprestar Livro</title>
</head>
<body>
    <h1>Emprestar Livro</h1>

    <form method="POST">
        <label for="id">ID do Livro:</label>
        <input type="number" id="id" name="id" required><br>

        <button type="submit">Emprestar</button>
    </form>

    <br><a href="index.php">Voltar para a página inicial</a>
</body>
</html>
