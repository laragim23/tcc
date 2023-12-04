<!DOCTYPE html>
<title>Iara Concept - Novo Vendedor</title>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>

<?php
require_once("conexao.php");

if (isset($_POST['voltar'])) {
 header("Location: listarVendedor.php");
}

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $status = $_POST['status'];

    $sql = "insert into vendedor 
            (nome, telefone, endereco, status) values 
            ('$nome', '$telefone', '$endereco', '$status')";

    mysqli_query($conexao, $sql);

    $mensagem = "Inserido com sucesso.";
}
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Novo Vendedor</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
                $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
                $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
                $status = isset($_POST['status']) ? $_POST['status'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                    <input type="text" class="form-control" value="<?= $nome ?>" name="nome" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                    <input type="text" class="form-control" value="<?= $endereco ?>" name="endereco">
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" class="form-control" value="<?= $telefone ?>" name="telefone"><span class="mascara"></span>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" value="<?= $status ?>" name="status">
                    <option selected>Selecione</option>
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                    </select>
                </div>

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