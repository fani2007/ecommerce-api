<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\CheckApiHeader;
use App\Http\Middleware\CheckCategoryActive;
use App\Http\Middleware\CheckTagNameNotEmpty;
use App\Http\Middleware\CheckOrderStatus;
use App\Http\Middleware\CheckQuantityPositive;
use App\Http\Middleware\CheckRatingRange;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.api.header'      => CheckApiHeader::class,
            'check.category.active' => CheckCategoryActive::class,
            'check.tag.name'        => CheckTagNameNotEmpty::class,
            'check.order.status'    => CheckOrderStatus::class,
            'check.quantity'        => CheckQuantityPositive::class,
            'check.rating'          => CheckRatingRange::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
