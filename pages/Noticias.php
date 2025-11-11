<?php
require_once __DIR__ . '/../includes/header.php';

// URL de busca de notícias sobre estágio
$feed_url = 'https://gru.ifsp.edu.br/busca.html?searchword=estagio&ordering=newest&searchphrase=all&areas[0]=content';

// Arquivo de cache
$cache_file = __DIR__ . '/../cache/noticias_estagio.json';
$cache_time = 3600; // 1 hora

$noticias = [];

// Carrega cache se existir e não expirou
if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $noticias = json_decode(file_get_contents($cache_file), true);
} else {
    // Captura HTML da página
    $html = file_get_contents($feed_url);
    if ($html !== false) {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $items = $xpath->query("//div[contains(@class,'item')]");
        foreach ($items as $item) {
            $a = $xpath->query(".//h2[contains(@class,'item-title')]/a", $item)->item(0);
            if (!$a) continue;

            $titulo = trim($a->textContent);
            $link = $a->getAttribute('href');

            $resumoNode = $xpath->query(".//div[contains(@class,'item-introtext')]", $item);
            $resumo = $resumoNode->length ? trim($resumoNode->item(0)->textContent) : '';

            $noticia = [
                'titulo' => $titulo,
                'link' => $link,
                'resumo' => $resumo
            ];

            // Adiciona notícia se ainda não estiver no cache
            if (!in_array($noticia, $noticias)) {
                $noticias[] = $noticia;
            }
        }

        // Salva cache
        file_put_contents($cache_file, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
?>

<section class="noticias">
    <h2>Notícias sobre Estágio</h2>

    <?php if (!empty($noticias)): ?>
        <ul>
            <?php foreach ($noticias as $noticia): ?>
                <li>
                    <a href="<?php echo $noticia['link']; ?>" target="_blank"><?php echo $noticia['titulo']; ?></a>
                    <p><?php echo $noticia['resumo']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma notícia encontrada no momento.</p>
    <?php endif; ?>
</section>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
