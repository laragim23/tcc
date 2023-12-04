<?php

require_once("conexao.php");

// Verifica se o ID do produto foi enviado
if (isset($_POST['produto_id'])) {
    $produtoId = $_POST['produto_id'];

    // Consulta SQL para obter o valor do produto
    $sql = "SELECT valor FROM produto WHERE id = $produtoId";
    $resultado = mysqli_query($conexao, $sql);

    if ($linha = mysqli_fetch_assoc($resultado)) {
        // Retorna o valor como resposta para a requisição AJAX
        echo $linha['valor'];
    } else {
        // Se o produto não for encontrado, retorna um valor padrão ou uma mensagem de erro
        echo '0.00'; 
    }
} else {
    // Se o ID do produto não foi enviado, retorna um valor padrão ou uma mensagem de erro
    echo '0.00'; 
}
?>
