<?php

protected $routeMiddleware = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'is_employee_or_admin' => \App\Http\Middleware\CheckEmployeeOrAdmin::class,
];
