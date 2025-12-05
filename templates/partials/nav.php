<?php
if (!isset($routeParser) || !$routeParser) {
    echo "<!-- nav: routeParser não disponível -->";
    return;
}

$currentPath = $current_uri ?? ($_SERVER['REQUEST_URI'] ?? '/');
$currentPath = strtok($currentPath, '?');

$is_active = function (string $routeName) use ($routeParser, $currentPath) : string {
    try {
        $url = $routeParser->urlFor($routeName);
        $u = rtrim($url, '/');
        $p = rtrim($currentPath, '/');
        if ($u === '') $u = '/';
        if ($p === '') $p = '/';
        return ($p === $u || strpos($p, $u) === 0) ? 'active' : '';
    } catch (\Throwable $e) {
        return '';
    }
};

$navItemClass = function(string $routeName) use ($is_active) {
    $base = 'flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors';
    $active = $is_active($routeName) ? 'bg-gray-100 text-sky-700' : 'text-gray-700 hover:bg-gray-50 hover:text-sky-600';
    return $base . ' ' . $active;
};
?>

<nav aria-label="Principal" class="w-full">
  <ul class="flex flex-col md:flex-row md:space-x-4 md:items-center">
    <li>
      <a href="<?= $routeParser->urlFor('site.index'); ?>"
         class="<?= $navItemClass('site.index'); ?>">
         <span>Início</span>
      </a>
    </li>

    <li>
      <a href="<?= $routeParser->urlFor('solicitacao.index'); ?>"
         class="<?= $navItemClass('solicitacao.index'); ?>">
         <span>Solicitação</span>
      </a>
    </li>

    <li>
      <a href="<?= $routeParser->urlFor('acompanhamento.index'); ?>"
         class="<?= $navItemClass('acompanhamento.index'); ?>">
         <span>Acompanhamento</span>
      </a>
    </li>

    <li>
      <a href="<?= $routeParser->urlFor('noticias.index'); ?>"
         class="<?= $navItemClass('noticias.index'); ?>">
         <span>Notícias</span>
      </a>
    </li>

    <li>
      <a href="<?= $routeParser->urlFor('site.recursos'); ?>"
         class="<?= $navItemClass('site.recursos'); ?>">
         <span>Recursos</span>
      </a>
    </li>
  </ul>
</nav>
