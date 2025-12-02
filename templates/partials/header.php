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
  <link rel="stylesheet" href="<?= ASSETS_URL ?>css/tailwind_output.css">

</head>
<body>
<header>
    <div class="flex flex-wrap justify-between px-10">
        
        <a href="<?php echo BASE_URL; ?>" class="brand flex items-center">
            <div class="flex flex-col space-y-0 p-0">
                <p class="text-sm m-0 p-0 leading-tight">Campus Guarulhos</p>
                <h1 class="text-lg m-0 p-0 font-bold leading-tight">Instituto Federal de São Paulo</h1> 
                <p class="text-sm m-0 p-0 leading-tight">Coordenadoria de Extensão</p>
            </div>
        </a>
        
        <button id="menu-button" class="md:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white">
          <span class="text-white text-2xl font-bold">&#9776;</span> 
        </button>
        
        <nav class="w-full"> 
            <div id="main-nav-links" class="nav-links hidden md:flex w-full flex-col"> 
                <?php include PARTIALS_PATH . 'nav.php'; ?>
            </div>
        </nav>
    </div>
</header>

<main class="px-5 md:px-10 w-full">