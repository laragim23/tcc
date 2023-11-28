<!DOCTYPE html>
<title>Iara Concept - Clientes</title>

<?php
session_start();
if(empty($_SESSION)){
    print "<script>location.href='index.php';</script>"; 
}
?>
 
<?php
//1. conectar no banco de dados (ip, usuario, senha, nome do banco)

require_once("conexao.php");
$corpo = "";

if (isset($_GET['id'])) { 
  // Excluir registros relacionados na tabela compravendaproduto
  $sqlExcluircompravendaProduto = "DELETE FROM compravendaproduto WHERE compravenda_id IN (SELECT id FROM compravenda WHERE cliente_id = " . $_GET['id'] . ")";
  mysqli_query($conexao, $sqlExcluircompravendaProduto);

  // Excluir registros relacionados na tabela condicional
  $sqlExcluircompravenda = "DELETE FROM compravenda WHERE cliente_id = " . $_GET['id'];
  mysqli_query($conexao, $sqlExcluircompravenda);


  // Excluir registros relacionados na tabela condicionalproduto
  $sqlExcluirCondicionaisProduto = "DELETE FROM condicionalproduto WHERE condicional_id IN (SELECT id FROM condicional WHERE cliente_id = " . $_GET['id'] . ")";
  mysqli_query($conexao, $sqlExcluirCondicionaisProduto);

  // Excluir registros relacionados na tabela condicional
  $sqlExcluirCondicionais = "DELETE FROM condicional WHERE cliente_id = " . $_GET['id'];
  mysqli_query($conexao, $sqlExcluirCondicionais);

  // Agora você pode excluir o cliente
  $sqlExcluirCliente = "DELETE FROM cliente WHERE id = " . $_GET['id'];
  mysqli_query($conexao, $sqlExcluirCliente);

  $mensagem = "Exclusão realizada com sucesso.";
}


// Inicializar a variável de pesquisa
$pesquisaCliente = "";

// Verificar se o formulário de pesquisa foi enviado
if (isset($_POST['pesquisar'])) {
  $pesquisaCliente = $_POST['cliente'];
  // Adicionar condição WHERE apenas quando a pesquisa é realizada
  $V_WHERE = " AND nome LIKE '%$pesquisaCliente%'";
} else {
  $V_WHERE = ""; // Inicializar a variável quando não houver pesquisa
}

//2. Preparar a sql
$sql = "SELECT * FROM cliente WHERE 1 = 1 $V_WHERE"; 

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);

require_once("cabecalho.php");

?>

<main id="main" class="main">

  <section class="section">

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Lista de Clientes 
          <a href="cadastrarCliente.php"><button type="button" class="btn btn-primary mb-2">+
              <span class="badge bg-white text-primary"></span>
            </button></a>
        </h5>
        <?php require_once("mensagem.php") ?>

        <!-- Formulário de pesquisa -->
        <div class="row">
                    <div class="mb-3">
                        <form method="post">
                            <div class="input-group">
                            <input type="text" class="form-control" id="cliente" name="cliente" 
                            value="<?php echo $pesquisaCliente; ?>" placeholder="Pesquisar cliente">
                            <button name="pesquisar" stype="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

        <!-- Default Table -->
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nome</th>
              <th scope="col">CPF</th>
              <th scope="col">Telefone</th>
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
                  <?= $linha['cpf'] ?>
                </td>
                <td>
                  <?= $linha['telefone'] ?>
                </td>
                <td><a href="alterarCliente.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                      class="bi bi-pencil-square"></i></a>

                  <a onclick="openModal(<?= $linha['id'] ?>)" data-bs-toggle="modal" 
                  data-bs-target="#exampleModal" name="info" class="btn btn-info">
                  <i class="bi bi-eye"></i></a>

                  <a href="listarCliente.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
                    onclick="return confirm('Deseja excluir mesmo?')">
                    <i class="bi bi-trash3-fill"></i>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <!-- End Default Table Example -->
      </div>
    </div>

  </section>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Informações do Cliente</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span><b>Nome: </b><span id="modalNome"></span></span> <br>
                        <span><b>CPF: </b><span id="modalCpf"></span></span><br>
                        <span><b>Telefone: </b><span id="modalTelefone"></span></span> <br>
                        <span><b>Cidade: </b><span id="modalCidade"></span></span> <br>
                        <span><b>Estado: </b><span id="modalEstado"></span></span> <br>
                        <span><b>Endereço: </b><span id="modalEndereco"></span></span><br>
                        <span><b>Status: </b><span id="modalStatus"></span></span><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

</main><!-- End #main -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
        const modalContent = document.querySelector('.modal-content'); // Seletor para o conteúdo do modal
        const modal = document.querySelector('.modal.fade'); // Seletor para o modal completo

        function openModal(userId) {
            const modal = document.querySelector('.modal.fade'); // Seletor para o modal completo

            // Faça uma solicitação AJAX para buscar os dados do usuário com base no userId
            $.ajax({
                type: 'GET',
                url: 'buscar_dados_usuario.php',
                data: { id: userId },
                dataType: 'json',
                success: function (data) {
                    // Preencha os campos do modal com os dados do usuário
                    document.getElementById('modalNome').textContent = data.nome;
                    document.getElementById('modalTelefone').textContent = data.telefone;
                    document.getElementById('modalEndereco').textContent = data.endereco;
                    document.getElementById('modalCpf').textContent = data.cpf;
                    document.getElementById('modalCidade').textContent = data.cidade;
                    document.getElementById('modalEstado').textContent = data.estado;
                    document.getElementById('modalStatus').textContent = data.status;


                    modal.style.display = 'block'; // Defina o estilo de exibição como 'block' para mostrar o modal
                },
                error: function () {
                    alert('Falha ao buscar os dados do usuário.');
                }
            });
        }

        </script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

</main>  