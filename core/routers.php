<?php

class Router {
    protected $controller = 'homeController';
    protected $action = 'home';
    protected $params = [];

    private function parseUrl($uri) {
        // Get path only, strip query string if present
        $path = parse_url($uri, PHP_URL_PATH);
        if ($path === null) {
            $path = $uri;
        }
        // Remove WEBROOT prefix only (e.g. / or /inis/) so /account/login → account/login
        if (WEBROOT !== '' && strpos($path, WEBROOT) === 0) {
            $path = substr($path, strlen(WEBROOT));
        }
        // Strip index.php or index.php/ from path (some servers pass REQUEST_URI like /index.php/account/login)
        $path = preg_replace('#^index\.php/?#', '', $path);
        $path = trim($path, '/');
        if ($path === '') {
            return [];
        }
        return explode('/', filter_var($path, FILTER_SANITIZE_URL));
    }

    public function dispatch($uri) {
        $url = $this->parseUrl($uri);

        // Check controller
        if (isset($url[0]) && !empty($url[0])) {
            $controllerName = strtolower($url[0]) . 'Controller';
            $controllerPath = 'app/Controllers/' . $controllerName . '.php';
            if (file_exists($controllerPath)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Load controller
        $controllerPath = 'app/Controllers/' . $this->controller . '.php';
        if (!file_exists($controllerPath)) {
            die("Controller not found: $controllerPath");
        }

        require_once $controllerPath;
        $this->controller = new $this->controller;

        // Check action
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->action = $url[1];
            unset($url[1]);
        }

        // Assign params from path
        $pathParams = $url ? array_values($url) : [];

        // Get query string params from $_GET
        $queryParams = $_GET;

        // If query params exist, merge into path params as flat array
        if (!empty($queryParams)) {
            $this->params = array_merge($pathParams, [$queryParams]);
        } else {
            $this->params = $pathParams;
        }

        // Call action with params
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
}
?>