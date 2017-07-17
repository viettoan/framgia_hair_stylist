<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    protected static $repositories = [
        'comment' => [
            \App\Contracts\Repositories\CommentRepository::class,
            \App\Repositories\CommentRepositoryEloquent::class,
        ],
        'department' => [
            \App\Contracts\Repositories\DepartmentRepository::class,
            \App\Repositories\DepartmentRepositoryEloquent::class,
        ],
        'render_booking' => [
            \App\Contracts\Repositories\RenderBookingRepository::class,
            \App\Repositories\RenderBookingRepositoryEloquent::class,
        ],
        'order_booking' => [
            \App\Contracts\Repositories\OrderBookingRepository::class,
            \App\Repositories\OrderBookingRepositoryEloquent::class,
        ],
        'user' => [
            \App\Contracts\Repositories\UserRepository::class,
            \App\Repositories\UserRepositoryEloquent::class,
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
