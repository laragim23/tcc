<!DOCTYPE html>
<title>Iara Concept - Novo Produto</title>

<?php

    //1. Conectar no BD (IP, usuario, senha, nome do bd)
    require_once("conexao.php");

    if (isset($_POST['voltar'])) {
      header("Location: listarProduto.php");
     }

    if (isset($_POST['salvar'])) {
    //2. Receber os dados para inserir no BD
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $categoria_id = $_POST['categoria_id'];

    //3. Preparar a SQL
    $sql = "insert into produto (descricao, valor, categoria_id) values ('$descricao', '$valor', '$categoria_id')";

    //4. Executar a SQL
    mysqli_query($conexao, $sql);

    //5. Mostrar uma mensagem ao usuário
    $mensagem = "Inserido com sucesso.";
}
?>
<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Produtos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Início</a></li>
          <li class="breadcrumb-item">Produtos</li>
          <li class="breadcrumb-item active">Novo Produto</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Novo Produto</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $valor = isset($_POST['valor']) ? $_POST['valor'] : "";
                $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label">Descrição</label>
                    <input type="text" class="form-control" value="<?= $descricao ?>" name="descricao">
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Valor</label>
                    <input type="text" class="form-control" value="<?= $valor ?>" name="valor">
                </div>

                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select">
                        <option selected>Selecione</option>
                        <?php
                        $sql = "select * from categoria order by nome";
                        $resultado = mysqli_query($conexao, $sql);

                        while ($linha = mysqli_fetch_array($resultado)):
                            $id = $linha['id'];
                            $nome = $linha['nome'];

                            echo "<option value='{$id}'>{$nome}</option>";
                        endwhile;
                        ?>
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

<?php require_once("rodape.php") ?>