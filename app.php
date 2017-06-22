<?php

class App
{
    private $base_path;
    private $views_path;
    private $uri;
    private $routes = [];

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];

    }

    public function basePath($path = '')
    {
        if (empty($path)) {
            return $this->base_path;
        }

        $this->base_path = '/' . trim($path, '/');
    }

    public function viewsPath($path = '')
    {
        if (empty($path)) {
            return $this->views_path;
        }

        $this->views_path = trim($path, '/');
    }

    public function map($pattern, $callback)
    {
        $this->routes[] = [trim($pattern, '/'), $callback];
    }

    public function dispatch()
    {
        $this->match($this->uri);
    }

    private function match($uri)
    {
        $request = $this->resolve($uri);

        foreach ($this->routes as $route) {
            list($pattern, $callback) = $route;
            $pattern = explode('/', trim($pattern, '/'));
            $page = $pattern[0];
            unset($pattern[0]);
            $params = $pattern;

            if ($request['page'] === $page) {
                if (count($params) === count($request['params'])) {

                    $params = array_combine($params, $request['params']);

                    return $callback($params);
                }
            }
        }
        header('HTTP/1.1 404 Not Found');

        return $this->render('errors/404');
    }

    private function resolve($uri)
    {
        $uri = trim($uri, '/');
        $uri = substr($uri, strlen($this->basePath()));
        $uri = explode('/', trim($uri, '/'));

        $params = [];
        $params['page'] = $uri[0];
        unset($uri[0]);
        $params['params'] = array_values($uri);

        return $params;
    }

    public function render($page, $params = [])
    {
        $basePath = $this->basePath();
        $page = trim($page, '/');
        require $this->viewsPath() . '/' . $page . '.php';
    }
}
