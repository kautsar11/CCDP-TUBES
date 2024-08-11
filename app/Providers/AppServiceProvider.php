<?php

namespace App\Providers;

use App\Builders\DataBuilder;
use App\Adapters\PreviewAdapter;
use Illuminate\Pagination\Paginator;
use App\Strategies\UriParserStrategy;
use App\Builders\DataBuilderInterface;
use Illuminate\Support\ServiceProvider;
use App\Adapters\PreviewAdapterInterface;
use App\Strategies\DefaultUriParserStrategy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DataBuilderInterface::class, DataBuilder::class);
        $this->app->bind(PreviewAdapterInterface::class, PreviewAdapter::class);
        $this->app->singleton(UriParserStrategy::class, DefaultUriParserStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
