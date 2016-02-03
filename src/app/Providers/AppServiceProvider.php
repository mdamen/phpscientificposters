<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Poster\PosterRepositoryInterface', 'App\Repositories\Poster\PosterRepository');
		$this->app->bind('App\Repositories\Attachment\AttachmentRepositoryInterface', 'App\Repositories\Attachment\AttachmentRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
    }
}
