<!DOCTYPE html>
<title>Relatório de Vendas</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<?php
// Inclua a conexão com o banco de dados
require_once("conexao.php");

// Excluir registros relacionados na tabela compravendaproduto
if (isset($_GET['id'])) {
    // Excluir registros relacionados na tabela compravendaproduto
    $sqlExcluirProdutos = "DELETE FROM compravendaproduto WHERE compravenda_id = " . $_GET['id'];
    mysqli_query($conexao, $sqlExcluirProdutos);

    // Agora você pode excluir a venda na tabela compravenda
    $sqlExcluirVenda = "DELETE FROM compravenda WHERE id = " . $_GET['id'];
    mysqli_query($conexao, $sqlExcluirVenda);
}

// Inicializar a variável de pesquisa
$pesquisaCliente = "";

// Verificar se o formulário de pesquisa foi enviado
if (isset($_POST['pesquisar'])) {
    $pesquisaCliente = $_POST['cliente'];
}

// Consulta SQL para obter as vendas por cliente com base na pesquisa
$sql = "SELECT v.id, c.nome as cliente, v.datacriacao
        FROM compravenda v
        INNER JOIN cliente c ON v.cliente_id = c.id
        WHERE c.nome LIKE '%$pesquisaCliente%'
        ORDER BY v.datacriacao desc"; //v.total

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);

// Recuperar o valor total da variável de sessão
$valorTotal = isset($_SESSION['valorTotal']) ? $_SESSION['valorTotal'] : 0;

// Limpar a variável de sessão
unset($_SESSION['valorTotal']);

?>

<?php require_once("cabecalho.php") ?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Relatório de Vendas
                <a href="relatorio_vendas_vendedor.php" class="btn btn-primary"><i class="bi bi-person-vcard"></i></a>
                <a href="relatorio_condicionais_cliente.php" class="btn btn-primary"><i class="bi bi-basket"></i></a>
                </h5> 
 
                <!-- Formulário de pesquisa -->
                <div class="row">
                    <div class="mb-3">
                        <form method="post">
                            <div class="input-group">
                            <input type="text" class="form-control" id="cliente" name="cliente" 
                            value="<?php echo $pesquisaCliente; ?>" placeholder="Pesquisar cliente">
                            <button name="pesquisar" stype="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th>Cliente</th>
                            <th>Data da Venda</th>
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
                                <?= $linha['cliente'] ?>
                                </td>
                                <td>
                                <?= date("d/m/Y", strtotime($linha['datacriacao']))?>
                                </td>
                                <td>
                                    <?php
                                    $total = 0;
                                    $sqlProduto = "select quantidade, valorunitario from compravendaproduto where compravenda_id = " . $linha['id'];
                                    $resultadoVendaProduto = mysqli_query($conexao, $sqlProduto);
                                    if (mysqli_num_rows($resultadoVendaProduto) > 0) {
                                    
                                        while ($linhaVendaProduto = mysqli_fetch_array($resultadoVendaProduto)) {
                                            $total += ($linhaVendaProduto['quantidade'] * $linhaVendaProduto['valorunitario']);
                                        }
                                    }
                                    $sqlDesconto = "select desconto from compravenda where id = " . $linha['id'];
                                    $resultadoDesconto = mysqli_query($conexao, $sqlDesconto);
                                    $linhaDesconto = mysqli_fetch_array($resultadoDesconto);
                                    echo $total - $linhaDesconto['desconto']; ?>
                                </td>
                                <td><a href="alterarVenda.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a>

                                <a onclick="openModal(<?= $linha['id'] ?>)" data-bs-toggle="modal" 
                                data-bs-target="#exampleModal" name="info" class="btn btn-info">
                                <i class="bi bi-eye"></i></a>

                                <a href="relatorio_vendas_cliente.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
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

