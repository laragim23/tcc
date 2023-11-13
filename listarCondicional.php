<!DOCTYPE html>
<title>Iara Concept - Condicionais</title>

<?php
//1. conectar no banco de dados (ip, usuario, senha, nome do banco)

require_once("conexao.php");
$corpo = "";

//EXCLUSÃO//
if (isset($_GET['id'])) { //verifica se o botão excluir foi clicado
  $sql = "delete from condicional where id = " . $_GET['id'];
  mysqli_query($conexao, $sql);
  $mensagem = "Exclusão realizada com sucesso.";
}

//geração de sql para relatório
$V_WHERE = "";
if (isset($_POST['pesquisar'])) { //se clicou no botao pesquisar
  $V_WHERE = " and nome like '%" . $_POST['nome'] . "%' ";
}

//2. Preparar a sql
$sql = "select * from condicional";

//3. Executar a SQL
$resultado = mysqli_query($conexao, $sql);

?>

<?php require_once("cabecalho.php") ?>


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Condicionais</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Início</a></li>
        <li class="breadcrumb-item active">Condicionais</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Lista de Condicionais
          <a href="cadastrarCondicional.php"><button type="button" class="btn btn-primary mb-2">+
              <span class="badge bg-white text-primary"></span>
            </button></a>
        </h5>
        <?php require_once("mensagem.php") ?>

        <!--pesquisar usuarios-->
        <div class="container">
          <h4 class="card-title">Pesquisar</h4>
          <div class="row">
            <div class="col-mb-3">
              <form method="post">
                <div class="input-group">
                  <input name="nome" type="text" class="form-control" placeholder="Insira o nome do cliente">
                  <button name="pesquisar" stype="button" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Default Table -->
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Cliente</th>
              <th scope="col">Telefone</th>
              <th scope="col">Vendedor</th>
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
                  <?= $linha['cliente_id'] ?>
                </td>
                <td>
                  <?= $linha['telefone'] ?>
                </td>
                <td>
                  <?= $linha['vendedor_id'] ?>
                </td>
                <td><a href="alterarCondicional.php?id=<?= $linha['id'] ?>" class="btn btn-warning"><i
                      class="bi bi-pencil-square"></i></a>

                  <a onclick="openModal(<?= $linha['id'] ?>)" data-bs-toggle="modal" 
                  data-bs-target="#exampleModal" name="info" class="btn btn-info">
                  <i class="bi bi-eye"></i></a>

                  <a href="listarCondicional.php? id=<?= $linha['id'] ?>" class="btn btn-danger"
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
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Informações do Condicional</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span><b>Cliente: </b><span id="modalCliente_id"></span></span> <br>
                        <span><b>Telefone: </b><span id="modalTelefone"></span></span><br>
                        <span><b>Endereço: </b><span id="modalEndereco"></span></span> <br>
                        <span><b>Produto: </b><span id="modalProduto_id"></span></span> <br>
                        <span><b>Vendedor: </b><span id="modalVendedor_id"></span></span> <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>



</main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

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

        function openModal(condicionalId) {
            const modal = document.querySelector('.modal.fade'); // Seletor para o modal completo

            // Faça uma solicitação AJAX para buscar os dados do usuário com base no userId
            $.ajax({
                type: 'GET',
                url: 'buscar_dados_condicional.php',
                data: { id: condicionalId },
                dataType: 'json',
                success: function (data) {
                    // Preencha os campos do modal com os dados do usuário
                    document.getElementById('modalCliente_id').textContent = data.cliente_id;
                    document.getElementById('modalTelefone').textContent = data.telefone;
                    document.getElementById('modalEndereco').textContent = data.endereco;
                    document.getElementById('modalProduto_id').textContent = data.produto_id;
                    document.getElementById('modalVendedor_id').textContent = data.vendedor_id;

                    modal.style.display = 'block'; // Defina o estilo de exibição como 'block' para mostrar o modal
                },
                error: function () {
                    alert('Falha ao buscar os dados do condicional.');
                }
            });
        }

        </script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

</main>  