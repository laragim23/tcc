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

if(isset($_GET['id'])) {
    $idVenda = $_GET['id'];
} else {
    $idVenda = $_POST['id'];
}

if (isset($_POST['finalizar'])) {

    $id = $_POST['id']; // Adicione essa linha para obter o ID da venda
    $cliente_id = $_POST['cliente_id'];
    $vendedor_id = $_POST['vendedor_id'];
    $operacao = $_POST['operacao'];
    $formaPagamento = $_POST['formaPagamento'];
    $situacao = $_POST['situacao'];
    $desconto = str_replace(',', '.', $_POST['desconto']);

    $sql2 = "update compravenda
    set cliente_id= '$cliente_id', 
    vendedor_id = '$vendedor_id',
    desconto = '$desconto',
    operacao = '$operacao',
    formaPagamento = '$formaPagamento',
    situacao = '$situacao'
    where id = $id";

    //compravendaproduto
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    for ($i = 0; $i < count($produto_id); $i++) {
        $produtoId = $produto_id[$i];
        $quantidadeProduto = $quantidade[$i];
        $valorProduto = $valor[$i];

        $sqlUpdateProduto = "UPDATE compravendaproduto
                            SET quantidade = '$quantidadeProduto',
                            valorunitario = '$valorProduto'
                            WHERE compravenda_id = '$id' AND produto_id = '$produtoId'";

        mysqli_query($conexao, $sqlUpdateProduto);

        if (isset($_POST['excluido'][$i]) && $_POST['excluido'][$i] == 1) {
            $sqlExcluirProduto = "DELETE FROM compravendaproduto 
                                  WHERE compravenda_id = '$id' AND produto_id = '$produtoId'";
            mysqli_query($conexao, $sqlExcluirProduto);
        }
    }


    //5. Mostrar uma mensagem ao usuário
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
                                            <option value="Pago">Pago</option>
                                            <option value="Pendente">Pendente</option>
                                            <option value="Atrasado">Atrasado</option>
                                            <option value="Devolvido">Devolvido</option>
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
                                            <option value="Venda">Venda</option>
                                            <option value="Condicional">Condicional</option>
                                        </select>
                                    </div>

                                    <div class="col-md-9">
                                        <label for="cliente_id" class="form-label">Cliente</label>
                                        <select class="form-select" name="cliente_id" id="cliente">
                                            <option class="fonte-status">Selecione</option>
                                            <?php
                                            $sql = "select * from cliente order by nome";
                                            $resultado = mysqli_query($conexao, $sql);

                                            while ($linha = mysqli_fetch_array($resultado)):
                                                $cliente_id = $linha['id'];
                                                $nome = $linha['nome'];

                                                // Verifica se o cliente atual é o que deve ser pré-selecionado
                                                $selected = ($cliente_id == $linhaVenda['cliente_id']) ? 'selected' : '';
                                                settype($cliente_id, "integer");
                                                echo "<option value='{$cliente_id}' {$selected}>{$nome}</option>";
                                            endwhile;
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="formaPagamento" class="form-label">Pagamento</label>
                                        <select class="form-select" id="formaPagamento" name="formaPagamento">
                                            <option selected>Selecione</option>
                                            <option value="Dinheiro">Dinheiro</option>
                                            <option value="Pix">Pix</option>
                                            <option value="Crédito">Cartão de crédito</option>
                                            <option value="Débito">Cartão de Débito</option>
                                        </select>
                                    </div>

                                    <div class="col-md-9">
                                        <label for="vendedor_id" class="form-label">Vendedor</label>
                                        <select name="vendedor_id" class="form-select"
                                            value="<?= $linha['vendedor_id'] ?>">
                                            <option selected>Selecione</option>
                                            <?php
                                            $sql = "select * from vendedor order by nome";
                                            $resultado = mysqli_query($conexao, $sql);

                                            while ($linha = mysqli_fetch_array($resultado)):
                                                $vendedor_id = $linha['id'];
                                                $nome = $linha['nome'];

                                                // Verifica se o cliente atual é o que deve ser pré-selecionado
                                                $selected = ($vendedor_id == $linhaVenda['vendedor_id']) ? 'selected' : '';

                                                echo "<option value='{$vendedor_id}' {$selected}>{$nome}</option>";
                                            endwhile;

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <!-- 
                                        <script>
                                            $(document).ready(function () {
                                                // Função para lidar com a mudança no campo de seleção de produtos
                                                $('#produto_id').change(function () {
                                                    // Obtém o ID do produto selecionado
                                                    var produtoId = $(this).val();

                                                    // Faz uma requisição AJAX para obter o valor do produto
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'obter_valor_produto.php', // Substitua pelo caminho correto do seu script PHP
                                                        data: { produto_id: produtoId },
                                                        success: function (response) {
                                                            // Atualiza o campo "Valor Un." com o valor obtido
                                                            $('#valorUnitario').val(response);
                                                        },
                                                        error: function () {
                                                            console.log('Erro ao obter o valor do produto.');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                            -->
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

                                                    // ... Seu código existente ...
                                                    function Excluir() {
                                                        var par = $(this).closest("tr"); // Encontra a linha mais próxima (tr)
                                                        var produtoId = par.find('select[name^="produto_id"]').val();

                                                        // Marca o produto como excluído
                                                        par.find('input[name^="excluido"]').val(1);

                                                        par.remove();
                                                        recalculaValores();
                                                    }

                                                    // Função para formatar o valor como string
                                                    function formataValorStr(valor) {
                                                        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                                                    }

                                                    // Função para preencher a tabela de produtos
                                                    function preencherTabelaProdutos(produtos) {
                                                        // Limpa a tabela antes de adicionar as novas linhas
                                                        $("#tabela tbody").empty();

                                                        for (let i = 0; i < produtos.length; i++) {
                                                            $(document).on("click", ".btnExcluir", Excluir);
                                                            const produto = produtos[i];
                                                            // Adicione a lógica para adicionar a linha na tabela com os dados do produto
                                                            $("#tabela").append(
                                                                "<tr>" +
                                                                // Adicione os campos do produto aqui
                                                                "<td>" +
                                                                "<select class=\"form-select\" name=\"produto_id[]\">" +
                                                                "<option value=\"" + produto.produto_id + "\">" + produto.nome + "</option>" +
                                                                "</select>" +
                                                                "</td>" +
                                                                "<td><input type=\"text\" class=\"form-control\" name=\"quantidade[]\" value=\"" + produto.quantidade + "\"></td>" +
                                                                "<td><input type=\"text\" class=\"form-control\" name=\"valor[]\" value=\"" + produto.valorunitario + "\"></td>" +
                                                                // Adicione outros campos necessários
                                                                "<td class=\"text-right\">" + formataValorStr(produto.valorunitario * produto.quantidade) + "</td>" +
                                                                "<td class=\"text-center\">" +
                                                                "<button type=\"button\" class=\"btn btn-danger btn-sm btnExcluir\">" +
                                                                "<i class=\"bi bi-trash3-fill\"></i>" +
                                                                "</button>" +
                                                                "</td>" +
                                                                "</tr>"
                                                            );
                                                        }

                                                        // Restante do seu código...

                                                    }

                                                    // Restante do seu código...
                                                </script>
                                                <!--
                                                <
                                                if (isset($linhaVenda['id'])) {
                                                    $sqlProduto = "select produto.nome as nome, quantidade, valorunitario from compravendaproduto 
                                                    inner join produto on compravendaproduto.produto_id = produto.id where compravenda_id = " . $linhaVenda['id'];

                                                    $resultadoVendaProduto = mysqli_query($conexao, $sqlProduto);

                                                    if (mysqli_num_rows($resultadoVendaProduto) > 0) {
                                                        while ($linhaVendaProduto = mysqli_fetch_array($resultadoVendaProduto)) {
                                                            echo '<tr><th scope="col">' . $linhaVendaProduto['nome'] . '</th>
                                                    <th scope="col" class="text-right">' . $linhaVendaProduto['quantidade'] . '</th>
                                                    <th scope="col" class="text-right">' . $linhaVendaProduto['valorunitario'] . '</th>
                                                    <th scope="col" class="text-right">' . $linhaVendaProduto['valorunitario'] * $linhaVendaProduto['quantidade'] . '</th>
                                                    <th scope="col" class="text-center"><button type="button" class="btn btn-danger btn-sm btnExcluir">
                                                    <i class="bi bi-trash3-fill"></i>
                                                    </button></th></tr>';
                                                        }
                                                    }
                                                }

                                                ?>
                                            -->
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
<?php require_once("rodape.php") ?>