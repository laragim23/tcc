<!DOCTYPE html>
<title>Iara Concept - Novo Cliente</title>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>

<?php
require_once("conexao.php");

if (isset($_POST['voltar'])) {
 header("Location: listarCliente.php");
} 

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "insert into cliente 
            (nome, cpf, telefone, endereco, cidade, estado) values 
            ('$nome', '$cpf', '$telefone', '$endereco', '$cidade', '$estado')";

    mysqli_query($conexao, $sql);

    $mensagem = "Inserido com sucesso.";
}
?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Clientes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Início</a></li>
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Novo Cliente</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Novo Cliente</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
                $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
                $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
                $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
                $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : "";
                $estado = isset($_POST['estado']) ? $_POST['estado'] : "";
                ?>
              </form>

              <!-- Multi Columns Form -->
              <form method="post" class="row g-3">
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label">Nome</label>
                    <input type="text" class="form-control" value="<?= $nome ?>" name="nome">
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">CPF</label>
                    <input type="text" id="cpf" class="form-control" value="<?= $cpf ?>" name="cpf" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" class="form-control" value="<?= $telefone ?>" name="telefone" required><span class="mascara"></span>
                </div>
                
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Estado</label>
                    <select class="form-select" aria-label="Default select example" value="<?= $estado ?>" name="estado">
                            <option selected>Selecione</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Cidade</label>
                    <input type="text" class="form-control" value="<?= $cidade ?>" name="cidade">
                </div>

                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label">Endereço</label>
                    <input type="text" class="form-control" value="<?= $endereco ?>" name="endereco">
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
    Inputmask("999.999.999-99").mask("#cpf");
</script>
<script>
    $(document).ready(function () {
        $('#telefone').inputmask('(99) 99999-9999');
    });
</script>
<?php require_once("rodape.php") ?>