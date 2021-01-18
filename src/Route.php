<?php

namespace Teachable;

class Route
{
    private string $route;
    private string $method;
    private $toRun;

    public function __construct(string $route, string $method, callable $toRun)
    {
        $this->route = $route;
        $this->method = $method;
        $this->toRun = $toRun;
    }

    public function isRoute(string $uri, string $method): bool
    {
        // Check it's the correct method.
        if (strtolower($method) !== strtolower($this->method)) {
            return false;
        }
        // given a URL such as localhost:8080/foo/bar this will return /foo/bar
        $path = parse_url($uri, PHP_URL_PATH);
        // Run a regular expression on the route e.g. '/get/foo' will be parsed as '~^/get/foo$~i'
        return preg_match("~^{$this->route}$~i", $path);
    }

    public function run(string $uri)
    {
        // Work out the parameters from the URI. This runs the regular expression against the URI and any named
        // parameters in the regular expression will be parsed into an array
        $parameters = [];
        $path = parse_url($uri, PHP_URL_PATH);
        preg_match("~{$this->route}~i", $path, $parameters);
        // If this request has a body, send it into the route method
        $body = file_get_contents('php://input');
        // Assume we're using Content-Type: application/json
        header('Content-Type: application/json');

        return ($this->toRun)($parameters, $body);
    }
}
