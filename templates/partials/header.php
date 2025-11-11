<?php
$page_title = $page_title ?? "Coordenação de Estágios — IFSP";
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link rel="icon" type="image/x-icon" href="<?php echo ASSETS_URL; ?>favicon.ico">
  <meta name="description" content="Protótipo HTML das páginas e formulários: Antes de Iniciar, Durante e Encerrando o Estágio. Baseado no manual de identidade visual do IFSP.">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css?v=<?php echo time(); ?>">

</head>
<body>
<header>
  <div class="container">
    <div class="brand">
      <a href="<?php echo BASE_URL; ?>">
          <img src="<?php echo ASSETS_URL; ?>logo_ifsp.png" alt="Logo IFSP">
      </a>
      <div>
        <h1>Coordenação de Estágios — IFSP</h1>
        <?php include INCLUDES_PATH . 'nav.php'; ?>
      </div>
    </div>
  </div>
</header>
<main class="container">