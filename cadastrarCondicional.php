<!DOCTYPE html>
<title>Iara Concept - Novo Condicional</title>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>

<?php
require_once("conexao.php");

if (isset($_POST['voltar'])) {
 header("Location: listarCondicional.php");
}

if (isset($_POST['salvar'])) {
    $cliente_id = $_POST['cliente_id'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $produto_id = $_POST['produto_id'];
    $vendedor_id = $_POST['vendedor_id'];
    $valor = $_POST['valor'];

    $sql = "insert into condicional 
            (cliente_id, telefone, endereco, produto_id, vendedor_id, valor) values 
            ('$cliente_id', '$telefone', '$endereco', '$produto_id', '$vendedor_id', '$valor')";

    mysqli_query($conexao, $sql);

    $mensagem = "Inserido com sucesso.";
}
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Condicionais</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Início</a></li>
          <li class="breadcrumb-item">Condicionais</li>
          <li class="breadcrumb-item active">Novo Condicional</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Novo Condicional</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
                $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
                $valor = isset($_POST['valor']) ? $_POST['valor'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
                    <div class="col-md-12">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" value="<?= $cliente_id ?>" name="cliente_id">
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

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" value="<?= $telefone ?>" name="telefone" 
                    class="form-control" required><span class="mascara"></span>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                    <input type="text" class="form-control" value="<?= $endereco ?>" name="endereco">
                </div>

                <div class="col-md-12">
                        <label for="vendedor_id" class="form-label">Vendedor</label>
                        <select name="vendedor_id" class="form-select" value="<?= $vendedor_id ?>" name="vendedor_id">
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
                        <select name="produto_id" class="form-select" value="<?= $produto_id ?>" name="produto_id">
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
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" value="<?= $valor ?>" name="valor">
                    </div>

                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary btn-square" 
                        onclick="adicionarFormulario()"><i class="bi bi-plus"></i></button>
                    </div>

                    <!-- Botão para adicionar um novo formulário -->
                    <div id="form-container">
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
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control">
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

                    function removerFormulario(botao) {
                        // Obtém o elemento pai do botão (o formulário) e remove-o
                        var formulario = botao.parentElement.parentElement.parentElement;
                        document.getElementById("form-container").removeChild(formulario);
                    }
                </script>

                <div class="text-center">
                  <button type="submit" name="salvar" class="btn btn-primary">Cadastrar</button>
                  <button type="submit" name="voltar" class="btn btn-secondary">Voltar</button>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>

    </section>

</main>

<script>
    $(document).ready(function () {
        $('#telefone').inputmask('(99) 99999-9999');
    });
</script>
<?php require_once("rodape.php") ?>