<?php if (isset($mensagem)) { ?>
      <div class="alert alert-success" role="alert">
      <i class="fa-solid fa-square-check"></i>
      <?= $mensagem?>
    </div>
    <?php } ?>

    <?php if (isset($mensagem2)) { ?>
      <div class="alert alert-danger" role="alert">
      <i class="fa-solid fa-square-check"></i>
      <?= $mensagem2?>
    </div>
    <?php } ?>