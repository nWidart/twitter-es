<?php

namespace App\Providers;

use App\Twitter\Domain\TweetList;
use App\Twitter\Infrastructure\Repository\EventStoreTweetList;
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
        $this->app->bind(TweetList::class, EventStoreTweetList::class);
    }
}
