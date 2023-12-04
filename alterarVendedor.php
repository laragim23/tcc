<!DOCTYPE html>
<title>Iara Concept - Alterar Vendedor</title>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>

<?php
//1. Conectar no BD (IP, usuario, senha, nome do bd)
require_once("conexao.php");

if (isset($_POST['voltar'])) {
  header("Location: listarVendedor.php");
 }

if (isset($_POST['salvar'])) {
  //2. Receber os dados para inserir no BD
  $id = $_POST['id'];
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $endereco = $_POST['endereco'];
  $status = $_POST['status'];

  //3. Preparar a SQL
  $sql = "update vendedor
    set nome= '$nome',
    telefone = '$telefone',
    endereco = '$endereco',
    status = '$status'
    where id = $id";

  //4. Executar a SQL
  mysqli_query($conexao, $sql);

  //5. Mostrar uma mensagem ao usuário
  $mensagem = "Alterado com sucesso.";
}

//Busca usuário selecionado pelo "usuarioListar.php"
$sql = "select * from vendedor where id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultado)
  ?>

<?php require_once("cabecalho.php") ?>

<main id="main" class="main">

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Alterar Vendedor</h5>

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
              <input type="hidden" class="form-control" value="<?= $linha['id'] ?>" name="id">
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                    <input type="text" class="form-control" value="<?=$linha['nome'] ?>" name="nome" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" class="form-control" value="<?=$linha['telefone'] ?>" name="telefone"><span class="mascara"></span>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                    <input type="text" class="form-control" value="<?=$linha['endereco'] ?>" name="endereco">
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