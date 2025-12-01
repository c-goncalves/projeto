<?php

class Router {
    private $routes = [];
    private $params = [];
    private $current_route = '';

    /**
     * Rota GET
     */
    public function get($route, $page) {
        $this->routes['GET'][$route] = $page;
    }

    /**
     * Rota POST
     */
    public function post($route, $page) {
        $this->routes['POST'][$route] = $page;
    }

    /**
     * Dispara o roteamento
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $this->parseUrl();

        // Rota exata
        if (isset($this->routes[$method][$route])) {
            $this->loadPage($this->routes[$method][$route]);
            return;
        }

        // Rota com parâmetros nomeados (ex: /usuarios/{id})
        foreach ($this->routes[$method] as $pattern => $page) {
            if ($this->matchRoute($pattern, $route)) {
                $this->loadPage($page);
                return;
            }
        }

        // 🔹 Subrotas simples (ex: /solicitacao/inicio)
        foreach ($this->routes[$method] as $pattern => $page) {
            if ($this->matchSubRoute($pattern, $route)) {
                $this->loadPage($page);
                return;
            }
        }

        // 🔹 Subrotas aninhadas (ex: /solicitacao/curso/licenciatura/plano)
        foreach ($this->routes[$method] as $pattern => $page) {
            if ($this->matchNestedRoute($pattern, $route)) {
                $this->loadPage($page);
                return;
            }
        }

        $this->notFound();
    }

    /**
     * Captura a URL atual (sem query string)
     */
    private function parseUrl() {
        $base_path = dirname($_SERVER['SCRIPT_NAME']);
        $request_uri = $_SERVER['REQUEST_URI'];

        if ($base_path !== '/' && strpos($request_uri, $base_path) === 0) {
            $request_uri = substr($request_uri, strlen($base_path));
        }

        if (strpos($request_uri, '?') !== false) {
            $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
        }

        $this->current_route = trim($request_uri, '/');
        return $this->current_route;
    }

    /**
     * Rotas com placeholders tipo {id}
     */
    private function matchRoute($pattern, $url) {
        $regex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $url, $matches)) {
            array_shift($matches);
            preg_match_all('/\{([^}]+)\}/', $pattern, $param_names);
            foreach ($param_names[1] as $index => $name) {
                if (isset($matches[$index])) {
                    $_GET[$name] = $matches[$index];
                    $this->params[$name] = $matches[$index];
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Subrotas simples: /solicitacao/inicio
     */
    private function matchSubRoute($pattern, $url) {
        if (str_starts_with($url, $pattern . '/')) {
            $acao = trim(substr($url, strlen($pattern)), '/');
            $_GET['acao'] = $acao;
            $this->params['acao'] = $acao;
            return true;
        }
        return false;
    }

    /**
     * 🔹 NOVO — Subrotas aninhadas: /solicitacao/curso/licenciatura/plano
     */
    private function matchNestedRoute($pattern, $url) {
        if (!str_starts_with($url, $pattern . '/')) return false;

        $subpath = trim(substr($url, strlen($pattern)), '/');
        $segments = explode('/', $subpath);

        // Padrão detectado: /solicitacao/curso/{curso}/{acao}
        if (count($segments) >= 3 && $segments[0] === 'curso') {
            $_GET['curso'] = $segments[1];
            $_GET['acao'] = $segments[2];
            $this->params = ['curso' => $segments[1], 'acao' => $segments[2]];
            return true;
        }

        return false;
    }

    /**
     * Carrega o arquivo da rota
     */
    private function loadPage($page) {
        $page_path = PAGES_PATH . $page . '.php';
        if (file_exists($page_path)) {
            $params = $this->params;
            require $page_path;
        } else {
            $this->notFound();
        }
    }

    /**
     * Página 404
     */
    private function notFound() {
        http_response_code(404);
        echo "
        <div style='padding: 50px; text-align: center;'>
            <h1>404 - Página não encontrada</h1>
            <p>A rota '{$this->current_route}' não existe.</p>
            <a href='" . BASE_URL . "'>Voltar à homepage</a>
        </div>";
        exit;
    }

    public function getParams() {
        return $this->params;
    }
}
