<?php
// obter_valor_produto.php

// Inclua o arquivo de conexão
require_once("conexao.php");

// Verifique se o ID do produto foi enviado
if (isset($_POST['produto_id'])) {
    $produtoId = $_POST['produto_id'];

    // Consulta SQL para obter o valor do produto
    $sql = "SELECT valor FROM produto WHERE id = $produtoId";
    $resultado = mysqli_query($conexao, $sql);

    if ($linha = mysqli_fetch_assoc($resultado)) {
        // Retorna o valor como resposta para a requisição AJAX
        echo $linha['valor'];
    } else {
        // Se o produto não for encontrado, retorne um valor padrão ou uma mensagem de erro
        echo '0.00'; // Substitua pelo valor padrão ou mensagem desejada
    }
} else {
    // Se o ID do produto não foi enviado, retorne um valor padrão ou uma mensagem de erro
    echo '0.00'; // Substitua pelo valor padrão ou mensagem desejada
}
?>
