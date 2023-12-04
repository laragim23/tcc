<!DOCTYPE html>
<title>Iara Concept - Produtos</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>

<?php
$corpo = "listar";
require_once("conexao.php");

//EXCLUSÃO//
if (isset($_GET['id'])) { //verifica se o botão excluir foi clicado
  $sql = "delete from produto where id = " . $_GET['id'];
  mysqli_query($conexao, $sql);
  $mensagem = "Exclusão realizada com sucesso.";
}

// Inicializar a variável de pesquisa
$pesquisaProduto = "";

// Verificar se o formulário de pesquisa foi enviado
if (isset($_POST['pesquisar'])) {
  $pesquisaProduto = $_POST['produto'];
  // Adicionar condição WHERE apenas quando a pesquisa é realizada
  $V_WHERE = " AND nome LIKE '%$pesquisaProduto%'";
} else {
  $V_WHERE = ""; // Inicializar a variável quando não houver pesquisa
}

//2. Preparar a sql
$sql = "SELECT * FROM produto WHERE 1 = 1 $V_WHERE"; 

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <section class="section">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Lista de Produtos
                <a href="cadastrarProduto.php"><button type="button" class="btn btn-primary mb-2">+
                <span class="badge bg-white text-primary"></span>
              </button></a>
              </h5>
              <?php require_once("mensagem.php") ?>

            <!-- Formulário de pesquisa -->
            <div class="row">
                    <div class="mb-3">
                        <form method="post">
                            <div class="input-group">
                            <input type="text" class="form-control" id="produto" name="produto" 
                            value="<?php echo $pesquisaProduto; ?>" placeholder="Pesquisar produto">
                            <button name="pesquisar" stype="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

              <!-- Default Table -->
              <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Código de Barras</th>
                       
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
                        <td>
                        <?= $linha['valor'] ?>
                        </td>
                        <td>
                        <?= $linha['codBarras'] ?>
                        </td>
          
                        <td><a href="alterarProduto.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                            class="bi bi-pencil-square"></i></a>
                        <a href="listarProduto.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
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