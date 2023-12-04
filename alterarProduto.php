<!DOCTYPE html>
<title>Iara Concept - Alterar Produto</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<?php
//1. Conectar no BD (IP, usuario, senha, nome do bd)
require_once("conexao.php");

if (isset($_POST['voltar'])) {
  header("Location: listarProduto.php");
 }

if (isset($_POST['salvar'])) {
  //2. Receber os dados para inserir no BD
  $id = $_POST['id'];
  $nome = $_POST['nome'];
  $valor = $_POST['valor'];
  $codBarras = $_POST['codBarras'];

  //3. Preparar a SQL
  $sql = "update produto
    set nome= '$nome',
    valor = '$valor',
    codBarras = '$codBarras'
    where id = $id";

  //4. Executar a SQL
  mysqli_query($conexao, $sql);

  //5. Mostrar uma mensagem ao usuário
  $mensagem = "Alterado com sucesso.";
}

//Busca usuário selecionado pelo "usuarioListar.php"
$sql = "select * from produto where id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultado)
  ?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Alterar Produto</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $codBarras = isset($_POST['codBarras']) ? $_POST['codBarras'] : "";
                $valor = isset($_POST['valor']) ? $_POST['valor'] : "";
                $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
              <input type="hidden" class="form-control" value="<?= $linha['id'] ?>" name="id"> 
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                    <input type="text" class="form-control" value="<?=$linha['nome'] ?>" name="nome" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Valor</label>
                    <input type="text" class="form-control" value="<?=$linha['valor'] ?>" name="valor" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Código de barras</label>
                    <input type="text" class="form-control" value="<?=$linha['codBarras'] ?>" name="codBarras" required>
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

<?php require_once("rodape.php") ?>