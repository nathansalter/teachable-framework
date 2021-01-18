# teachable-framework
A very basic framework to learn the internals of how routing systems work

## How to use

You can either start from the `index.php` file, or build up a file like this:

```
<?php

require 'vendor/autoload.php';

use Teachable\Framework;

$framework = new Framework();

// Define routes here

$framework->run();

```

This is the most basic implementation. If a route isn't matched, the framework will return a 404 Not Found. For
simplicity this framework always assumes it will be returning `Content-Type: application/json`.

## Adding Routes

Adding routes is simple. Simply add either a `get`, `post`, `put` or `delete` method to the framework:

```
$framework->get('/', function () {
    echo json_encode([
        'message' => 'Hello world!'
    ]);
});
```

You can also accept parameters by using Regular Expressions:

```
$framework->get('/foo/(?<id>[0-9]+)', function ($parameters) {
    echo json_encode([
        'message' => 'Found id: ' . $parameters['id'];
    ]);
});
```

If you're using a request with a body, you can also accept that in the second parameter:

```
$framework->post('/foo', function ($parameters, $body) {
    echo json_encode([
        'body' => $body
    ]);
});
```

## Running the Framework

For testing purposes, you can run the framework using the internal PHP server:

```
php -S localhost:8080
```

Then in a different terminal use CURL to test it:

```
curl -i http://localhost:8080/foo
```

Or to test with a different method type:

```
curl -i -XPOST http://localhost:8080/foo -d '{"foo": "bar"}'
```

