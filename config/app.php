<?php

return [
    'abstracts' => [
        'request' => Symfony\Component\HttpFoundation\Request::createFromGlobals(),
        'resolver' => App\Resolver::class,
    ]
];