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
  $comissao = $_POST['comissao'];

  //3. Preparar a SQL
  $sql = "update vendedor
    set nome= '$nome',
    telefone = '$telefone',
    comissao = '$comissao'
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

    <div class="pagetitle">
      <h1>Vendedores</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Início</a></li>
          <li class="breadcrumb-item">Vendedores</li>
          <li class="breadcrumb-item active">Alterar Vendedor</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Alterar Vendedor</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
                $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
                $comissao = isset($_POST['comissao']) ? $_POST['comissao'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
              <input type="hidden" class="form-control" value="<?= $linha['id'] ?>" name="id">
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                    <input type="text" class="form-control" value="<?=$linha['nome'] ?>" name="nome">
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" class="form-control" value="<?=$linha['telefone'] ?>" name="telefone" required><span class="mascara"></span>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Comissão (%)</label>
                    <input type="text" class="form-control" value="<?=$linha['comissao'] ?>" name="comissao">
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