<?php

require 'vendor/autoload.php';

use Teachable\Framework;

$framework = new Framework();

$framework->get('/', function () {
    echo json_encode([
        'message' => 'Hello world!'
    ]);
});

$framework->get('/foo/(?<id>[0-9]+)', function ($parameters) {
    echo json_encode([
        'parameters' => $parameters
    ]);
});

$framework->post('/foo', function (array $params, string $body) {
    $data = json_decode($body, true);
    if (!isset($data['print'])) {
        echo json_encode([
            'error' => 'You must supply the "print" parameter'
        ]);
        header('HTTP/1.1 400 Bad Request');
        return;
    }

    echo json_encode($data['print']);
});

$framework->run();
