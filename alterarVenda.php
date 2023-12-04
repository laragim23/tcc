<!DOCTYPE html>
<title>Iara Concept - Alterar Venda</title>

<?php
session_start();
if (empty($_SESSION)) {
    print "<script>location.href='index.php';</script>";
}
?>

<?php



require_once("conexao.php");

if (isset($_GET['id'])) {
    $idVenda = $_GET['id'];
} else {
    $idVenda = $_POST['id'];
}

if (isset($_GET["idProduto"])) {
    $sqlDelete = "delete from compravendaproduto where produto_id = " . $_GET["idProduto"] . " and compravenda_id = " . $idVenda;
    mysqli_query($conexao, $sqlDelete);
    $mensagem = "Excluído com sucesso.";
}

if (isset($_POST['finalizar'])) {
    // ... (seu código existente)

    $formaPagamento = $_POST['formaPagamento'];
    $operacao = $_POST['operacao'];
    $situacao = $_POST['situacao'];

    echo $formaPagamento . '' . $operacao . '' . $situacao . '' . $idVenda;

    // Atualizar os campos no banco de dados
    $sqlUpdateCampos = "UPDATE compravenda 
                     SET formaPagamento = '$formaPagamento', 
                         operacao = '$operacao', 
                         situacao = '$situacao' 
                     WHERE id = $idVenda";
    mysqli_query($conexao, $sqlUpdateCampos);


    // Mostrar mensagem de sucesso
    $mensagem = "Alterado com sucesso.";
}

// Busca a venda selecionada
$sqlVenda = "SELECT * FROM compravenda WHERE id = $idVenda";
$resultadoVenda = mysqli_query($conexao, $sqlVenda);
$linhaVenda = mysqli_fetch_array($resultadoVenda);

// Busca os produtos da venda
$sqlProdutos = "SELECT * FROM compravendaproduto WHERE compravenda_id = $idVenda";
$resultadoProdutos = mysqli_query($conexao, $sqlProdutos);
$total = 0;
$sqlProduto = "select quantidade, valorunitario from compravendaproduto where compravenda_id = " . $linhaVenda['id'];
$resultadoVendaProduto = mysqli_query($conexao, $sqlProduto);

if (mysqli_num_rows($resultadoVendaProduto) > 0) {

    while ($linhaVendaProduto = mysqli_fetch_array($resultadoVendaProduto)) {
        $total += ($linhaVendaProduto['quantidade'] * $linhaVendaProduto['valorunitario']);
    }
}

// Antes do cabeçalho HTML, adicione este bloco de código
$sqlProduto = "SELECT cvp.quantidade, cvp.valorUnitario, p.nome 
               FROM compravendaproduto cvp 
               JOIN produto p ON cvp.produto_id = p.id 
               WHERE cvp.compravenda_id = " . $linhaVenda['id'];

$resultadoVendaProduto = mysqli_query($conexao, $sqlProduto);

if (mysqli_num_rows($resultadoVendaProduto) > 0) {
    while ($linhaVendaProduto = mysqli_fetch_array($resultadoVendaProduto)) {
        $produto = array(
            'nome' => $linhaVendaProduto['nome'],
            'quantidade' => $linhaVendaProduto['quantidade'],
            'valorunitario' => $linhaVendaProduto['valorUnitario'],
            // Adicione outros campos necessários
        );
        $productos[] = $produto;
    }
}

// Busca os produtos da venda
$sqlProdutos = "SELECT * FROM compravendaproduto WHERE compravenda_id = $idVenda";
$resultadoProdutos = mysqli_query($conexao, $sqlProdutos);

// Initialize $produto_id
$produto_id = isset($_POST['produto_id']) ? $_POST['produto_id'] : [];

// Restante do código...

// Loop para exibir os produtos
for ($i = 0; $i < count($produto_id); $i++) {
    $produtoId = $produto_id[$i];
    // Restante do código...
}


$produtos_json = json_encode($productos);

require_once("cabecalho.php");

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="compra-venda.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<main id="main" class="main">
    <section class="section">
        <div class="container card d-flex card-body" style="margin: auto; width: 100%">
            <div class="row" style="width: 100%">
                <h5 class="card-title">Alterar Venda</h5>
                <?php require_once("mensagem.php") ?>
                <div class="container" style="margin: 0px; width: 100%">
                    <form name="form" action="alterarVenda.php" method="post">
                        <input type="hidden" class="form-control" value="<?= $linhaVenda['id'] ?>" name="id">

                        <div class="row">

                            <!-- div Resumo -->
                            <div class="col-md-4 order-md-2 mb-4">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Resumo</span>
                                </h4>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <span>Soma dos Produtos</span>
                                        <span class="text-muted">
                                            <div id="resumoSoma">0,00</div>
                                        </span>
                                    </li>
                                    <div class="input-group text-right">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold text-success">Desconto R$
                                            </div>
                                        </div>
                                        <input type="text" class="form-control text-right" name="desconto"
                                            value="<?= $linhaVenda['desconto'] ?>">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary" id="btnAplicarDesconto"><i
                                                    class="bi bi-check-lg"></i></button>
                                        </div>
                                    </div>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <h6 class="my-0">Total (R$)</h6>
                                        <strong>
                                            <div id="resumoValorTotal">
                                                <?php echo $total; ?>
                                            </div>
                                        </strong>
                                    </li>
                                    <div class="col-md-12">
                                        <label for="situacao" class="form-label">Situação</label>
                                        <select class="form-select" id="situacao" name="situacao">
                                            <option value="Pago" <?= ($linhaVenda['situacao'] == 'Pago') ? 'selected' : '' ?>>Pago</option>
                                            <option value="Pendente" <?= ($linhaVenda['situacao'] == 'Pendente') ? 'selected' : '' ?>>Pendente</option>
                                            <option value="Atrasado" <?= ($linhaVenda['situacao'] == 'Atrasado') ? 'selected' : '' ?>>Atrasado</option>
                                            <option value="Devolvido" <?= ($linhaVenda['situacao'] == 'Devolvido') ? 'selected' : '' ?>>Devolvido</option>
                                        </select>
                                    </div>
                                </ul>
                                <div class="input-group">
                                    <button type="submit" name="finalizar" value="finalizar"
                                        class="btn btn-primary btn-lg btn-block">Finalizar</button>
                                </div>
                            </div>

                            <!-- Dados -->
                            <div class="col-md-8 order-md-1">

                                <div class="row">

                                    <div class="col-md-3">
                                        <label for="operacao" class="form-label">Operação</label>
                                        <select id="operacao" name="operacao" required
                                            class="custom-select d-block w-100">
                                            <option value="Venda" <?= ($linhaVenda['operacao'] == 'Venda') ? 'selected' : '' ?>>Venda</option>
                                            <option value="Condicional" <?= ($linhaVenda['operacao'] == 'Condicional') ? 'selected' : '' ?>>Condicional</option>
                                        </select>
                                        </select>
                                    </div>

                                    <div class="col-md-9">
                                        <h3 for="cliente_id" class="form-label"><b>Cliente:</b>
                                            <?php
                                            $sql = "select * from cliente order by nome";
                                            $resultado = mysqli_query($conexao, $sql);
                                            $linha = mysqli_fetch_array($resultado);
                                            echo $linha['nome'];
                                            ?>
                                        </h3>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="formaPagamento" class="form-label">Pagamento</label>
                                        <select class="form-select" id="formaPagamento" name="formaPagamento">
                                            <option value="Dinheiro" <?= ($linhaVenda['formaPagamento'] == 'Dinheiro') ? 'selected' : '' ?>>Dinheiro</option>
                                            <option value="Pix" <?= ($linhaVenda['formaPagamento'] == 'Pix') ? 'selected' : '' ?>>Pix</option>
                                            <option value="Crédito" <?= ($linhaVenda['formaPagamento'] == 'Cartão de crédito') ? 'selected' : '' ?>>Cartão de crédito</option>
                                            <option value="Débito" <?= ($linhaVenda['formaPagamento'] == 'Cartão de Débito') ? 'selected' : '' ?>>Cartão de Débito</option>
                                        </select>
                                    </div>

                                    <div class="col-md-9">
                                        <h3 for="vendedor_id" class="form-label"><b>Vendedor:</b>
                                        <?php
                                        $sql = "select * from vendedor order by nome";
                                        $resultado = mysqli_query($conexao, $sql);
                                        $linha = mysqli_fetch_array($resultado);
                                        echo $linha['nome']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="mb-3">Lista de Produtos</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tabela" class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Produto</th>
                                                    <th scope="col" class="text-right">Qtd.</th>
                                                    <th scope="col" class="text-right">Preço Un.</th>
                                                    <th scope="col" class="text-right">Preço Total</th>
                                                    <th scope="col" class="text-center">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($i = 0; $i < count($produto_id); $i++) {
                                                    $produtoId = $produto_id[$i];
                                                    $quantidadeProduto = $quantidade[$i];
                                                    $valorProduto = $valor[$i];

                                                    // Adicione o campo excluido[] para cada produto
                                                    echo '<input type="hidden" name="excluido[' . $produtoId . ']" value="0">';

                                                    // Restante do seu código para exibir os campos do produto...
                                                    echo '<td><input type="text" class="form-control" name="quantidade[]" value="' . $quantidadeProduto . '"></td>';
                                                    echo '<td><input type="text" class="form-control" name="valor[]" value="' . $valorProduto . '"></td>';
                                                    // Adicione outros campos necessários
                                                
                                                    // Restante do seu código...
                                                }
                                                ?>
                                                <script>
                                                    // Antes da função Adicionar(), adicione este bloco de código
                                                    $(document).on("click", ".btnExcluir", Excluir);
                                                </script>
                                                <?php
                                                if (isset($linhaVenda['id'])) {
                                                    $sqlProduto = "SELECT p.nome AS nome, p.id as idProduto, cvp.quantidade, cvp.valorUnitario
                                                    FROM compravendaproduto cvp
                                                    INNER JOIN produto p ON cvp.produto_id = p.id
                                                    WHERE cvp.compravenda_id = " . $linhaVenda['id'];

                                                    $resultadoVendaProduto = mysqli_query($conexao, $sqlProduto);

                                                    if (mysqli_num_rows($resultadoVendaProduto) > 0) {
                                                        while ($linhaVendaProduto = mysqli_fetch_array($resultadoVendaProduto)) {
                                                            echo '<tr id="produto_<?php echo $produtoId; ?>">';
                                                            echo '<tr>';
                                                            echo '<th scope="col">' . $linhaVendaProduto['nome'] . '</th>';
                                                            echo '<th scope="col" class="text-right">' . $linhaVendaProduto['quantidade'] . '</th>';
                                                            echo '<th scope="col" class="text-right">' . $linhaVendaProduto['valorUnitario'] . '</th>';
                                                            echo '<th scope="col" class="text-right">' . ($linhaVendaProduto['valorUnitario'] * $linhaVendaProduto['quantidade']) . '</th>';
                                                            echo '<th scope="col" class="text-center">';
                                                            echo '<a href="alterarvenda.php?id=' . $idVenda . '&idProduto=' . $linhaVendaProduto['idProduto'] . '" onclick="return confirm(\'Deseja mesmo excluir o cadastro?\')"><i class="bi bi-trash3-fill"></i></a>';
                                                            echo '<i class="bi bi-trash3-fill"></i>';
                                                            echo '</button>';
                                                            echo '</th>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <hr class="mb-4">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

</main>

<script>
    $(document).ready(function () {
        $('#cliente').select2();
    });
</script>
<script>
    $(document).ready(function () {
        console.log(<?php echo $produtos_json; ?>); // Verifica se os produtos estão corretos
        preencherTabelaProdutos(<?php echo $produtos_json; ?>);
        // Restante do seu código...
    });
</script>
<script>
    $(document).on("click", ".btnExcluirProduto", function () {
        var row = $(this).closest('tr');  // Obtém a linha da tabela
        var produtoId = row.attr('id').replace('produto_', '');  // Obtém o ID do produto

        // Marca o produto como excluído no formulário
        $("input[name='excluido[" + produtoId + "]']").val(1);

        // Remove a linha da tabela
        row.remove();

        // Atualiza o resumo e o total
        atualizarResumo();
    });

    function atualizarResumo() {
        // Implemente a lógica para atualizar o resumo e o total aqui
        // ...

        // Exemplo de atualização do resumo total
        var novoTotal = calcularTotal();
        $('#resumoValorTotal').text(novoTotal.toFixed(2));
    }

    function calcularTotal() {
        // Implemente a lógica para calcular o novo total aqui
        // ...
    }
</script>
<script src="js/script.js"></script>

<?php require_once("rodape.php") ?>