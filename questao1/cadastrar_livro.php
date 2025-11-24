<?php
// Função para salvar os livros no arquivo JSON
function salvarLivros($livros) {
    file_put_contents('livros.json', json_encode($livros, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livros = json_decode(file_get_contents('livros.json'), true);

    // Captura os dados do formulário
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];

    // Adiciona o novo livro
    $novoLivro = [
        'id' => count($livros) + 1,
        'titulo' => $titulo,
        'autor' => $autor,
        'disponivel' => true
    ];
    
    $livros[] = $novoLivro;

    // Salva os livros no arquivo
    salvarLivros($livros);

    echo "<p>Livro cadastrado com sucesso!</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro</title>
</head>
<body>
    <h1>Cadastrar Novo Livro</h1>

    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br><a href="index.php">Voltar para a página inicial</a>
</body>
</html>
