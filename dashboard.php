<!DOCTYPE html>
<title>Iara Concept</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<link rel="stylesheet" type="text/css" media="screen" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" />
<style>
  .botao{
            width:100%;
            align-items: center;
            justify-content: center;
            display: flex;
        }

        .login{
            width:100%;
            height: 100vh;
            align-items: center;
            justify-content: center;
            display: flex;
        }
</style>

<?php require_once("cabecalho.php") ?>

<div class="login">
<main id="main" class="main">
  <div class="botao">
    <div class="pagetitle">
      <nav>
      <div class="container-fluid">
            
            <div class="row">
              <div class="col-md-4">
              <a class="btn btn-large btn-danger m-2 d-flex flex-column 
              justify-content-center align-items-center" style="width: 200px; height: 200px" href="compra-venda.php">
                <i class="bi bi-bag" style="font-size: 40px"></i>
                <span style="font-size: 30px">Cadastrar Venda</span>
              </a>
              </div>

              <div class="col-md-4">
                  <a class="btn btn-large btn-danger m-2 d-flex flex-column 
                  justify-content-center align-items-center" style="width: 200px; height: 200px" href="cadastrarProduto.php">
                    <i class="bi bi-dropbox" style="font-size: 40px"></i>
                    <span style="font-size: 30px">Cadastrar Produto</span>
                  </a> 
              </div>
          
              <div class="col-md-4">
                  <a class="btn btn-large btn-danger m-2 d-flex flex-column 
                  justify-content-center align-items-center" style="width: 200px; height: 200px" href="cadastrarCliente.php">
                    <i class="bi bi-people" style="font-size: 40px"></i>
                    <span style="font-size: 30px">Cadastrar Cliente</span>
                  </a>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                  <a class="btn btn-large btn-danger m-2 d-flex flex-column 
                  justify-content-center align-items-center" style="width: 200px; height: 200px" href="cadastrarVendedor.php">
                    <i class="bi bi-person-vcard" style="font-size: 40px"></i>
                    <span style="font-size: 30px">Cadastrar Vendedor</span>
                  </a>
              </div>

              <div class="col-md-4">
                  <a class="btn btn-large btn-danger m-2 d-flex flex-column 
                  justify-content-center align-items-center" style="width: 200px; height: 200px" 
                  href="relatorio_vendas_cliente.php">
                    <i class="bi bi-clipboard-data" style="font-size: 40px"></i>
                    <span style="font-size: 30px">Relatório de Venda</span>
                  </a>
              </div>

              <div class="col-md-4">
                  <a class="btn btn-large btn-danger m-2 d-flex flex-column 
                  justify-content-center align-items-center" style="width: 200px; height: 200px" 
                  href="relatorio_condicionais_cliente.php">
                    <i class="bi bi-clipboard-data" style="font-size: 40px"></i>
                    <span style="font-size: 30px">Relatório de Condicional</span>
                  </a>
              </div>
            </div>
      </div>
      </nav>
    </div><!-- End Page Title -->
  </div>
</main>
</div>


<?php require_once("rodape.php") ?>
