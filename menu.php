  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Iara Concept</span>
        
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-house"></i>
          <span>Início</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="relatorio_vendas_cliente.php">
          <i class="bi bi-bag"></i>
          <span>Vendas</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="relatorio_condicionais_cliente.php">
          <i class="bi bi-basket"></i>
          <span>Condicionais</span>
        </a>
      </li>

      <li class="nav-item"> 
        <a class="nav-link collapsed" href="listarCliente.php">
          <i class="bi bi-people"></i>
          <span>Clientes</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="listarVendedor.php">
          <i class="bi bi-person-vcard"></i>
          <span>Vendedores</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="listarProduto.php">
          <i class="bi bi-dropbox"></i>
          <span>Produtos</span>
        </a>
      </li>

      <!-- End Forms Nav -->

      <li class="nav-item">
          <?php
            print '<a href="logout.php" class="nav-link collapsed"><i class="bi bi-box-arrow-in-right"></i>Sair</a>';
          ?>
        
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->