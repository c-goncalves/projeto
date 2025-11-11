<?php
$current_uri = $_SERVER['REQUEST_URI'];
?>
<nav class="nav-links" aria-label="home">
   <a href="<?php echo BASE_URL; ?>"
      class="<?php echo ($current_uri === BASE_URL || $current_uri === BASE_URL . 'index.php') ? 'active' : ''; ?>">
      Início
   </a>
   <a href="<?php echo BASE_URL; ?>solicitacoes"
      class="<?php echo strpos($current_uri, '/solicitacoes') !== false ? 'active' : ''; ?>">
      Solicitação
   </a>
   <a href="<?php echo BASE_URL; ?>"
      class="<?php echo strpos($current_uri, '/andamento') !== false ? 'active' : ''; ?>">
      Acompanhamento
   </a>
   <a href="<?php echo BASE_URL; ?>"
      class="<?php echo strpos($current_uri, '/encerramento') !== false ? 'active' : ''; ?>">
      Finalização
   </a>
   <a href="<?php echo BASE_URL; ?>recursos"
      class="<?php echo strpos($current_uri, '/recursos') !== false ? 'active' : ''; ?>">
      Recursos
   </a>
   <a href="<?php echo BASE_URL; ?>"
      class="<?php echo strpos($current_uri, '/noticias') !== false ? 'active' : ''; ?>">
      Notícias
   </a>
</nav>