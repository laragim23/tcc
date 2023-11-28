<!DOCTYPE html>
<title>Iara Concept - Alterar Condicional</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<?php

require_once("conexao.php");

if(isset($_POST['finalizar'])) {

    $id = $_POST['id']; // Adicione essa linha para obter o ID da venda

    $cliente_id = $_POST['cliente'];
    $vendedor_id = $_POST['vendedor_id'];

    $sql = "UPDATE condicional
            SET cliente_id = '$cliente_id',
                vendedor_id = '$vendedor_id'
            WHERE id = $id";

    //compravendaproduto
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    for ($i = 0; $i < count($produto_id); $i++) {
        $sql = "UPDATE ccondicionalproduto
                SET condicional_id = '$id',
                    produto_id = '$produto_id[$i]',
                    quantidade = '$quantidade[$i]',
                    valorunitario = '$valor[$i]'
                WHERE id = $id"; 
        mysqli_query($conexao, $sql);
    }

    //4. Executar a SQL
    mysqli_query($conexao, $sql);
    
    //5. Mostrar uma mensagem ao usuário
    $mensagem = "Alterado com sucesso.";

    }

    // Busca a venda selecionada
$idCondicional = $_GET['id'];
$sqlCondicional = "SELECT * FROM condicional WHERE id = $idCondicional";
$resultadoCondicional = mysqli_query($conexao, $sqlCondicional);
$linhaCondicional = mysqli_fetch_array($resultadoCondicional);

// Busca os produtos da venda
$sqlProdutos = "SELECT * FROM condicionalproduto WHERE condicional_id = $idCondicional";
$resultadoProdutos = mysqli_query($conexao, $sqlProdutos);
    
require_once("cabecalho.php"); 

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="condicional.js"></script> 

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<main id="main" class="main">
<section class="section">
<div class="container card d-flex card-body" style="margin: auto; width: 100%">  
<div class="row" style="width: 100%">
    <h5 class="card-title">Alterar Condicional</h5>
    <?php require_once("mensagem.php") ?>
    <div class="container" style="margin: 0px; width: 100%">
    <form name="form" action="condicional.php" method="post">
            
    <div class="row">
        
        <!-- div Resumo -->
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Resumo</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <span>Total (R$)</span>
                    <span class="text-muted"><div id="resumoSoma">0,00</div></span>
                </li>
            </ul>
            <div class="input-group">
                <button type="submit" name="finalizar" value="finalizar" class="btn btn-primary btn-lg btn-block">Finalizar</button>
            </div>
        </div>

        <!-- Dados -->
        <div class="col-md-8 order-md-1">

            <div class="row">
                
                <div class="col-md-12">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select class="form-select" name="cliente[]" id="cliente" value="<?=$linha['cliente'] ?>">
                        <option class="fonte-status">Selecione</option>
                        <?php
                        $sql = "select * from cliente order by nome";
                        $resultado = mysqli_query($conexao, $sql);

                        while ($linha = mysqli_fetch_array($resultado)):
                            $cliente_id = $linha['id'];
                            $nome = $linha['nome'];

                            echo "<option value='{$cliente_id}'>{$nome}</option>";
                        endwhile;
                        ?>

                    </select>
                </div>

                <div class="col-md-12">
                    <label for="vendedor_id" class="form-label">Vendedor</label>
                    <select name="vendedor_id" class="form-select" value="<?=$linha['vendedor_id'] ?>">
                            <option selected>Selecione</option>
                            <?php
                            $sql = "select * from vendedor order by nome";
                            $resultado = mysqli_query($conexao, $sql);

                            while ($linha = mysqli_fetch_array($resultado)):
                                $id = $linha['id'];
                                $nome = $linha['nome'];

                                echo "<option value='{$id}'>{$nome}</option>";
                            endwhile;
                            ?>
                        </select>
                </div>
            </div>
            <hr>
            
            <h4 class="mb-3">Produtos</h4>

            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="produto_id">Produto</label>
                        <select name="produto_id" id="produto_id" class="form-select" 
                        value="<?=$linha['produto_id'] ?>" aria-label="Default select example">
                            <option value="">-- Selecione --</option>
                            <?php
                            $sql = "select * from produto order by nome";
                            $resultado = mysqli_query($conexao, $sql);

                            while ($linha = mysqli_fetch_array($resultado)){
                                $id = $linha['id'];
                                $nome = $linha['nome'];

                                echo "<option value='{$id}'>{$nome}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="qtd">Qtd.</label>
                            <input type="number" id="quantidade" name="quantidade" class="form-control" value='1'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="valorUnitario">Valor Un.</label>
                            <div class="input-group mb-2 text-right">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">R$</div>
                                </div>
                                <input type="text" id="valorUnitario" name="valorUnitario" placeholder='0,00' class="form-control text-right">
                            </div>
                        </div>
                    </div>

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

                    <div class="col-md-2">
                        <div class="form-group">
                            <label style="color: white">aaaaa</label>
                            <button type="button" class="btn btn-secondary" class="col-md-15" id="btnAdicionar">Adicionar</button>
                        </div>
                    </div>
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
                            <!-- Conteúdo dinâmico -->
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

<?php require_once("rodape.php") ?>