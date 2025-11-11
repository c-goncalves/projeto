
<?php

/** URL amigável
 * 
 * Ex:
 * url('solicitacoes/cursos/ads/inicio')
 * url('noticias', ['id' => 5])
 * url('', ['page' => 2])
 */

function url($route = '', $params = []) {
    $url = BASE_URL . $route;
    
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    return $url;
}

/** redirecionamento
 * redirect('solicitacoes/cursos/ads/inicio');
 */

 function redirect($route, $code = 302) {
    header('Location: ' . url($route), true, $code);
    exit;
}

/** rota atual
 * $current = getCurrentRoute(); // 'solicitacoes/cursos/ads'
 */
function getCurrentRoute() {
    $base_path = dirname($_SERVER['SCRIPT_NAME']);
    $request_uri = $_SERVER['REQUEST_URI'];
    
    if ($base_path !== '/' && strpos($request_uri, $base_path) === 0) {
        $request_uri = substr($request_uri, strlen($base_path));
    }
    
    if (strpos($request_uri, '?') !== false) {
        $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
    }
    
    return trim($request_uri, '/');
}

/** retorna um parâmetro GET
 * $step = getParam('step', 'default_value');
 */
function getParam($key, $default = null) {
    return isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : $default;
}

?>