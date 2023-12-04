<!DOCTYPE html>
<title>Iara Concept - Alterar Cliente</title>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>

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
  header("Location: listarCliente.php");
 }

if (isset($_POST['salvar'])) {
  //2. Receber os dados para inserir no BD
  $id = $_POST['id'];
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $cpf = $_POST['cpf'];
  $endereco = $_POST['endereco'];
  $cidade = $_POST['cidade'];
  $estado = $_POST['estado'];
  $status = $_POST['status'];

  //3. Preparar a SQL
  $sql = "update cliente
    set nome= '$nome',
    cpf = '$cpf',
    telefone = '$telefone', 
    cidade = '$cidade',
    endereco = '$endereco',
    estado = '$estado',
    status = '$status'
    where id = $id";

  //4. Executar a SQL
  mysqli_query($conexao, $sql);

  //5. Mostrar uma mensagem ao usuário
  $mensagem = "Alterado com sucesso.";
}

//Busca usuário selecionado pelo "usuarioListar.php"
$sql = "select * from cliente where id = " . $_GET['id'];
$resultado = mysqli_query($conexao, $sql);
$linha = mysqli_fetch_array($resultado);
  ?>

<?php require_once("cabecalho.php") ?>

<main id="main" class="main"> 
    <section class="section">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Alterar Cliente</h5>

              <?php require_once("mensagem.php") ?>

              <form method="post" class="container">
                <?php
                $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
                $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : "";
                $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : "";
                $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : "";
                $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : "";
                $estado = isset($_POST['estado']) ? $_POST['estado'] : "";
                $status = isset($_POST['status']) ? $_POST['status'] : "";
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
                    <label for="exampleFormControlInput1" class="form-label">CPF</label>
                    <input type="text" id="cpf" class="form-control" value="<?=$linha['cpf'] ?>" name="cpf" required>
                </div>

                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Telefone</label>
                    <input type="text" id="telefone" class="form-control" value="<?=$linha['telefone'] ?>" name="telefone"><span class="mascara"></span>
                </div>
                
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Estado</label>
                    <select class="form-select" aria-label="Default select example" value="<?=$linha['estado'] ?>" name="estado">
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
                    <input type="text" class="form-control" value="<?=$linha['cidade'] ?>" name="cidade">
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
    Inputmask("999.999.999-99").mask("#cpf");
</script>
<script>
    $(document).ready(function () {
        $('#telefone').inputmask('(99) 99999-9999');
    });
</script>
<?php require_once("rodape.php") ?>