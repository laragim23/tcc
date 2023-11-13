<!DOCTYPE html>
<title>Iara Concept - Categorias</title>

<?php
$corpo = "listar";
require_once("conexao.php");

//Exclusao//
if (isset($_GET['id'])) {
  $sql = "delete FROM categoria where id =" . $_GET['id'];
  mysqli_query($conexao, $sql);
  $mensagem = "Exclusão realizada com sucesso.";
}
//2. Preparar a sql
$sql = "select * from categoria";

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Categorias</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Início</a></li>
          <li class="breadcrumb-item">Categorias</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Lista de Categorias
                <a href="cadastrarCategoria.php"><button type="button" class="btn btn-primary mb-2">+
                <span class="badge bg-white text-primary"></span>
              </button></a>
              </h5>
              <?php require_once("mensagem.php") ?>

              <!-- Default Table -->
              <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
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
                        <?= $linha['nome'] ?>
                        </td>
                        <td><a href="alterarCategoria.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                            class="bi bi-pencil-square"></i></a>
                        <a href="listarCategoria.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
                            onclick="return confirm('Deseja excluir mesmo?')">
                            <i class="bi bi-trash3-fill"></i>
                        </a>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

    </section>

</main><!-- End #main -->

<?php require_once("rodape.php") ?>