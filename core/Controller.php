<?php

class Controller {
    /**
     * Render a view file with layout headers and footers
     */
    protected function view(string $viewPath, array $data = []): void {
        extract($data);

        $header  = __DIR__ . '/../views/layout/header.php';
        $content = __DIR__ . '/../views/' . $viewPath . '.php';
        $footer  = __DIR__ . '/../views/layout/footer.php';

        if (file_exists($header)) {
            require_once $header;
        }

        if (file_exists($content)) {
            require $content;
        } else {
            echo "<p>View [{$viewPath}] not found.</p>";
        }

        if (file_exists($footer)) {
            require_once $footer;
        }
    }

    
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file [{$view}] not found.");
        }
    }

    /**
     * Redirect to a specific URL path
     */
    protected function redirect(string $url): void {
        $url = '/' . ltrim($url, '/');
        if (strpos($url, '/alzikrayat/public') !== 0) {
            $url = '/alzikrayat/public' . $url;
        }
        header("Location: " . $url);
        exit;
    }
}