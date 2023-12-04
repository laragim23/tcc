<?php
// Inclua seu código de conexão com o banco de dados aqui (semelhante ao código inicial)
require_once("conexao.php");
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Consulta para recuperar os dados do usuário com base no userId
    $sql = "SELECT * FROM cliente WHERE id = $userId";
    $result = mysqli_query($conexao, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $dadosUsuario = mysqli_fetch_assoc($result);
        echo json_encode($dadosUsuario); // Retorna os dados do usuário como JSON
    } else {
        echo json_encode(['error' => 'Usuário não encontrado']);
    }
} else {
    echo json_encode(['error' => 'Solicitação inválida']);
}
?>