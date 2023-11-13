<!DOCTYPE html>
<title>Iara Concept - Nova Venda</title>

<?php
//1. Conectar no BD (IP, usuario, senha, nome do bd)
require_once("conexao.php");

if (isset($_POST['voltar'])) {
    header("Location: listarVenda.php");
}

if (isset($_POST['salvar'])) {
    //2. Receber os dados para inserir no BD
    $valorTotal = $_POST['valorTotal'];
    $formaPagamento = $_POST['formaPagamento'];
    $quantidadeParcelas = $_POST['quantidadeParcelas'];
    $cliente_id = $_POST['cliente_id'];
    $produto_id = $_POST['produto_id'];
    $vendedor_id = $_POST['vendedor_id'];

    //3. Preparar a SQL
    $sql = "insert into venda (valorTotal, formaPagamento, quantidadeParcelas, cliente_id, produto_id, vendedor_id) values ('$valorTotal', '$formaPagamento', '$quantidadeParcelas', '$cliente_id', '$produto_id', '$vendedor_id')";

    //4. Executar a SQL
    mysqli_query($conexao, $sql);

    //5. Mostrar uma mensagem ao usuário
    $mensagem = "Inserido com sucesso.";
}
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Vendas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Início</a></li>
                <li class="breadcrumb-item">Vendas</li>
                <li class="breadcrumb-item active">Nova Venda</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nova Venda</h5>

                <?php require_once("mensagem.php") ?>

                <form method="post" class="container">
                    <?php
                    $quantidadeParcelas = isset($_POST['quantidadeParcelas']) ? $_POST['quantidadeParcelas'] : "";
                    $formaPagamento = isset($_POST['formaPagamento']) ? $_POST['formaPagamento'] : "";
                    $valorTotal = isset($_POST['valorTotal']) ? $_POST['valorTotal'] : "";
                    ?>
                </form>

                <!-- Multi Columns Form -->
                <form method="post" class="row g-3">
                    <div class="col-md-12">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select">
                            <option selected>Selecione</option>
                            <?php
                            $sql = "select * from cliente order by nome";
                            $resultado = mysqli_query($conexao, $sql);

                            while ($linha = mysqli_fetch_array($resultado)):
                                $id = $linha['id'];
                                $nome = $linha['nome'];

                                echo "<option value='{$id}'>{$nome}</option>";
                            endwhile;
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <label for="vendedor_id" class="form-label">Vendedor</label>
                        <select name="vendedor_id" class="form-select">
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

                    <div class="col-md-6">
                        <label for="produto_id" class="form-label">Produto</label>
                        <select name="produto_id" class="form-select">
                            <option selected>Selecione</option>
                            <?php
                            $sql = "select * from produto order by descricao";
                            $resultado = mysqli_query($conexao, $sql);

                            while ($linha = mysqli_fetch_array($resultado)):
                                $id = $linha['id'];
                                $descricao = $linha['descricao'];

                                echo "<option value='{$id}'>{$descricao}</option>";
                            endwhile;
                            ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="produto_id" class="form-label">Valor</label>
                        <input type="text" class="form-control" id="produto_id" oninput="calcularTotal()">
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary btn-square" 
                        onclick="adicionarFormulario()"><i class="bi bi-plus"></i></button>
                    </div>

                    <!-- Botão para adicionar um novo formulário -->
                    <div id="form-container">
                    </div>
                    
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Total: <span id="total">0</span></label>
                        <input type="text" class="form-control" value="<?= $valorTotal ?>" id="total" name="valorTotal">
                    </div>

                    <script>
                        function adicionarFormulario() {
                            // Crie um novo elemento de formulário
                            var novoFormulario = document.createElement("form");

                            // Adicione campos e elementos ao novo formulário
                            novoFormulario.innerHTML = `
                            <div class="row">
                            <div class="col-md-6">
                                <label for="produto_id" class="form-label">Produto</label>
                                <select name="produto_id" class="form-select">
                                    <option selected>Selecione</option>
                                    <?php
                                    $sql = "select * from produto order by descricao";
                                    $resultado = mysqli_query($conexao, $sql);

                                    while ($linha = mysqli_fetch_array($resultado)):
                                        $id = $linha['id'];
                                        $descricao = $linha['descricao'];

                                        echo "<option value='{$id}'>{$descricao}</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>

                        <div class="col-md-5">
                            <label for="produto_id" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="produto_id" oninput="calcularTotal()">
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger" 
                            onclick="removerFormulario(this)"><i class="bi bi-trash3-fill"></i></button>
                        </div>

                        </div>
                    `;

                        // Adicione o novo formulário ao contêiner
                        document.getElementById("form-container").appendChild(novoFormulario);
                    }

                    function calcularTotal() {
                        var valores = document.querySelectorAll('input[type="text"]');
                        var total = 0;

                        for (var i = 0; i < valores.length; i++) {
                            var valor = parseFloat(valores[i].value) || 0;
                            total += valor;
                        }

                        document.getElementById('total').textContent = total;
                    }

                    function removerFormulario(botao) {
                        // Obtém o elemento pai do botão (o formulário) e remove-o
                        var formulario = botao.parentElement.parentElement.parentElement;
                        document.getElementById("form-container").removeChild(formulario);
                        
                        // Recalcule o total quando um formulário é removido
                        calcularTotal();
                    }
                </script>

                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Forma de pagamento</label>
                        <select class="form-select" aria-label="Default select example" value="<?= $formaPagamento ?>"
                            name="formaPagamento">
                            <option selected>Selecione</option>
                            <option value="avista">Dinheiro</option>
                            <option value="P2">Cartão de crédito</option>
                            <option value="P3">Cartão de débito</option>
                            <option value="P4">Pix</option>
                            <option value="P5">Cheque</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Quantidade de parcelas</label>
                        <select class="form-select" aria-label="Default select example"
                            value="<?= $quantidadeParcelas ?>" name="quantidadeParcelas">
                            <option selected>Selecione</option>
                            <option value="avista">À vista</option>
                            <option value="P2">Prazo 2x</option>
                            <option value="P3">Prazo 3x</option>
                            <option value="P4">Prazo 4x</option>
                            <option value="P5">Prazo 5x</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="salvar" class="btn btn-primary">Cadastrar</button>
                        <button type="submit" name="voltar" class="btn btn-secondary">Voltar</button>
                    </div>
                       
                    </div>

            </div>
        </div>

        </div>

    </section>

</main>

<?php require_once("rodape.php") ?>