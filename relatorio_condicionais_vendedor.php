<!DOCTYPE html>
<title>Relatório de Condicionais</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<?php
// Inclua a conexão com o banco de dados
require_once("conexao.php");

// Verificar se o parâmetro 'id' está definido na URL
if (isset($_GET['id'])) {
    // Excluir registros relacionados na tabela compravendaproduto
    $sqlExcluirProdutos = "DELETE FROM condicionalproduto WHERE condicional_id = " . $_GET['id'];
    mysqli_query($conexao, $sqlExcluirProdutos);

    // Agora você pode excluir a venda na tabela compravenda
    $sqlExcluirCondicional = "DELETE FROM condicional WHERE id = " . $_GET['id'];
    mysqli_query($conexao, $sqlExcluirVenda);
}

// Inicializar a variável de pesquisa
$pesquisaVendedor = "";

// Verificar se o formulário de pesquisa foi enviado
if (isset($_POST['pesquisar'])) {
    $pesquisaVendedor = $_POST['vendedor'];
}

// Consulta SQL para obter as vendas por vendedor com base na pesquisa
$sql = "SELECT v.id, c.nome as vendedor, v.data
        FROM condicional v
        INNER JOIN vendedor c ON v.vendedor_id = c.id
        WHERE c.nome LIKE '%$pesquisaVendedor%'
        ORDER BY v.data desc"; //v.total

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);

?>

<?php require_once("cabecalho.php") ?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Relatório de Condicionais 
                <a href="relatorio_condicionais_cliente.php" class="btn btn-primary"><i class="bi bi-people"></i></a>
                <a href="relatorio_vendas_vendedor.php" class="btn btn-primary"><i class="bi bi-bag"></i></a> 
                </h5>

                <!-- Formulário de pesquisa -->
                <div class="row">
                    <div class="mb-3">
                        <form method="post">
                            <div class="input-group"> 
                            <input type="text" class="form-control" id="vendedor" name="vendedor" 
                            value="<?php echo $pesquisaVendedor; ?>" placeholder="Pesquisar vendedor">
                            <button name="pesquisar" stype="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th>Vendedor</th>
                            <th>Data do Condicional</th>
                            <th>Total (R$)</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>
                            <tr>
                                <th>
                                <?= $linha['id'] ?>
                                </th>
                                <td>
                                <?= $linha['vendedor'] ?>
                                </td>
                                <td>
                                <?= date("d/m/Y", strtotime($linha['data']))?>
                                </td>
                                <td><a href="alterarCondicional.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a>

                                <a onclick="openModal(<?= $linha['id'] ?>)" data-bs-toggle="modal" 
                                data-bs-target="#exampleModal" name="info" class="btn btn-info">
                                <i class="bi bi-eye"></i></a>

                                <a href="relatorio_condicionais_vendedor.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
                                    onclick="return confirm('Deseja excluir mesmo?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                                </td>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>    
        </div>        
    </section>
</main>

    <?php
// Fechar a conexão
mysqli_close($conexao);
?>

<?php require_once("rodape.php") ?>


