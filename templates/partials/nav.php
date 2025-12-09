<?php
$routeParser = $routeParser ?? null;

$current_uri  = $current_uri ?? ($_SERVER['REQUEST_URI'] ?? '/');
if ($current_uri === null) {
    $current_uri = '/';
}
$current_path = strtok((string) $current_uri, '?') ?: '/';
$current_path = (string) $current_path;

function navIsActive($routeParser, string $routeName, string $current_path): string
{
    try {
        $url = $routeParser->urlFor($routeName);
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
    } catch (\Throwable $e) {
        return '';
    }

    $path = rtrim($path, '/') ?: '/';
    $cur  = rtrim($current_path, '/') ?: '/';

    $is = ($cur === $path) || strpos($cur . '/', $path . '/') === 0;

    return $is ? : '';
}

function navUrl($routeParser, string $routeName): string
{
    try {
        return $routeParser->urlFor($routeName);
    } catch (\Throwable $e) {
        return '#';
    }
}
?>

<nav aria-label="Principal" class="w-full">
  <ul class="flex flex-col md:flex-row md:space-x-4 md:items-center">
    <li>
      <a href="<?= navUrl($routeParser, 'site.index') ?>"
        class="block px-3 py-2 font-medium <?= navIsActive($routeParser, 'site.index', $current_path) ?>">
         Início
      </a>
    </li>

    <li>
      <a href="<?= navUrl($routeParser, 'solicitacao.index') ?>"
           class="block px-3 py-2 font-medium <?= navIsActive($routeParser, 'solicitacao.index', $current_path) ?>">
            Solicitação
      </a>
    </li>

    <li>
      <a href="<?= navUrl($routeParser, 'acompanhamento.index') ?>"
           class="block px-3 py-2 font-medium <?= navIsActive($routeParser, 'acompanhamento.index', $current_path) ?>">
            Acompanhamento
      </a>
    </li>

    <li>
       <a href="<?= navUrl($routeParser, 'noticias.index') ?>"
           class="block px-3 py-2 font-medium <?= navIsActive($routeParser, 'noticias.index', $current_path) ?>">
            Notícias
      </a>
    </li>

    <li>
       <a href="<?= navUrl($routeParser, 'site.recursos') ?>"
           class="block px-3 py-2 font-medium <?= navIsActive($routeParser, 'site.recursos', $current_path) ?>">
            Recursos
      </a>
    </li>
  </ul>
</nav>
