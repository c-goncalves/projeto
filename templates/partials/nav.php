<?php
$is_active = function ($name) use ($routeParser, $current_uri) {
    $url = $routeParser->urlFor($name);
    return strpos($current_uri, $url) !== false ? 'active' : '';
};
?>

<nav class="nav-links" aria-label="home">
    
    <a href="<?= $routeParser->urlFor('site.home'); ?>"
       class="<?= $is_active('site.home'); ?>">
       Início
    </a>
    
    <a href="<?= $routeParser->urlFor('solicitacao.index'); ?>"
       class="<?= $is_active('solicitacao.index'); ?>">
       Solicitação
    </a>
    <a href="<?= $routeParser->urlFor('acompanhamento.index'); ?>"
       class="<?= $is_active('acompanhamento.index'); ?>">
       Acompanhamento
    </a>
    <a href="<?= $routeParser->urlFor('noticias.index'); ?>"
       class="<?= $is_active('noticias.index'); ?>">
       Notícias
    </a>
    
    <a href="<?= $routeParser->urlFor('site.recursos'); ?>"
       class="<?= $is_active('site.recursos'); ?>">
       Recursos
    </a>
    
    </nav>