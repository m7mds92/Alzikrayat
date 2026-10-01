<?php

class Router {
    private array $routes = [];

    public function add(string $method, string $path, array $handler): void {
        $method = strtoupper($method);
        $path   = '/' . trim($path, '/');
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $requestUri = preg_replace('/^\/alzikrayat\/public/i', '', $requestUri);
        $requestUri = '/' . trim($requestUri, '/');
        $method     = strtoupper($_SERVER['REQUEST_METHOD']);

        if (isset($this->routes[$method][$requestUri])) {
            [$controllerName, $action] = $this->routes[$method][$requestUri];
            $controller = new $controllerName();
            $controller->$action();
            return;
        }

        foreach ($this->routes[$method] as $routePath => $handler) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', $routePath);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove full match string
                [$controllerName, $action] = $handler;

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $matches);
                        return;
                    }
                }
            }
        }

        http_response_code(404);
        echo "<h3>404 Not Found</h3>";
        echo "<p>Route [<strong>{$method} {$requestUri}</strong>] is not registered in public/index.php.</p>";
    }
}