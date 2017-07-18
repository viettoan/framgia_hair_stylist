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
        'department_dayoff' => [
            \App\Contracts\Repositories\DepartmentDayoffRepository::class,
            \App\Repositories\DepartmentDayoffRepositoryEloquent::class,
        ],
        'department' => [
            \App\Contracts\Repositories\DepartmentRepository::class,
            \App\Repositories\DepartmentRepositoryEloquent::class,
        ],
        'media' => [
            \App\Contracts\Repositories\MediaRepository::class,
            \App\Repositories\MediaRepositoryEloquent::class,
        ],
        'render_booking' => [
            \App\Contracts\Repositories\RenderBookingRepository::class,
            \App\Repositories\RenderBookingRepositoryEloquent::class,
        ],
        'order_booking' => [
            \App\Contracts\Repositories\OrderBookingRepository::class,
            \App\Repositories\OrderBookingRepositoryEloquent::class,
        ],
        'timesheet_department' => [
            \App\Contracts\Repositories\TimeSheetDepartmentRepository::class,
            \App\Repositories\TimeSheetDepartmentRepositoryEloquent::class,
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
