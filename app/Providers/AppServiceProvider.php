<?php

namespace App\Providers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\AbstractPaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        AbstractPaginator::defaultView('pagination::bootstrap-4');
        Schema::defaultStringLength(191);
        Builder::macro('orderByDesc', function ($query) {
            return $this->orderByRaw("({$query->limit(1)->toSql()}) desc");
        });
        Builder::macro('orderByAsc', function ($query) {
            return $this->orderByRaw("({$query->limit(1)->toSql()}) asc");
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
