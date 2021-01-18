<?php

namespace Teachable;

class Framework
{
    /**
     * This is an array of Route objects. Each object will be called in turn to see if it matches
     *
     * @var Route[]
     */
    private array $routes = [];

    public function get(string $route, callable $toRun)
    {
        $this->routes[] = new Route($route, 'get', $toRun);
    }

    public function post(string $route, callable $toRun)
    {
        $this->routes[] = new Route($route, 'post', $toRun);
    }

    public function put(string $route, callable $toRun)
    {
        $this->routes[] = new Route($route, 'put', $toRun);
    }

    public function delete(string $route, callable $toRun)
    {
        $this->routes[] = new Route($route, 'delete', $toRun);
    }

    public function run()
    {
        // This is the URI that is called for the server (e.g. localhost:8080/foo/bar)
        $uri = $_SERVER['REQUEST_URI'];
        // This is the HTTP method for the server (e.g. POST, GET)
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            if ($route->isRoute($uri, $method)) {
                $route->run($uri);
                // Now that we've run the route, stop processing. This stops us from accidentally running multiple
                // routes on the same endpoint
                return;
            }
        }

        // We haven't matched any routes here, return a 404 not found
        header('HTTP/1.1 404 Not Found');
        echo json_encode([
            'error' => 'Page not found'
        ]);
    }
}
