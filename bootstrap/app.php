<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.group.header' => \App\Http\Middleware\CheckGroupHeader::class,
            'check.userid.required' => \App\Http\Middleware\CheckUserIdRequired::class,
            'check.category.name' => \App\Http\Middleware\CheckCategoryName::class,
            'check.product.stock' => \App\Http\Middleware\CheckProductStock::class,
            'check.order.status' => \App\Http\Middleware\CheckOrderStatus::class,
            'check.tag.name' => \App\Http\Middleware\CheckTagName::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
