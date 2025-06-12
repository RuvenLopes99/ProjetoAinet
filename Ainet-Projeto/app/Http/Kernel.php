<?php

protected $routeMiddleware = [
    // ... outros middlewares
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
