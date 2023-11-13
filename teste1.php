<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Iara Concept</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Aug 30 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<?php

    //1. Conectar no BD (IP, usuario, senha, nome do bd)
    require_once("conexao.php");

    if (isset($_POST['entrar'])) {
        header("Location: listarVenda.php");
    }

    if (isset($_POST['entrar'])) {

    //2. Receber os dados para inserir no BD
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];

    //3. Preparar a SQL
    $sql = "insert into usuario (email, senha, nome) values ('$email', '$senha', '$nome')";

    //4. Executar a SQL
    mysqli_query($conexao, $sql);

}
?>

<form method="post" class="container">
    <?php
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    ?>
</form>

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <form action="autenticacao.php" method="post">
        <div class="card mx-auto" style="width: 30rem; height: 30rem;">
        <div class="card-body text-center">

          <br><br><br>
          <h2 style="text-align: center">Login</h2>
          <br>
          <!-- Email input -->

          <div class="w-75 mx-auto">
            <div class="form-outline mb-2">
              <input name="email" type="email" id="email" class="form-control" placeholder="Endereço de email" />
              <label class="form-label" for="email"></label>
            </div>
          </div>

          <!-- Password input -->
          <div class="w-75 mx-auto">
            <div class="form-outline mb-2">
              <input name="senha" type="password" id="senha" class="form-control" placeholder="Senha" />
              <label class="form-label" for="senha"></label>
            </div>
          </div>

          <!-- 2 column grid layout for inline styling -->
          <div class="row mb-4">

            <div class="col"> 
              <!-- Simple link -->
              <a href="#!">Esqueceu a senha?</a>
            </div>
          </div>

          <!-- Submit button -->
            <div class="text-center">
                <a href="listarVenda.php" button type="submit" name="entrar" class="btn btn-primary">Entrar</button></a>
            </div>



        </div>
      </div>
    </form>
  </div>
</div>


