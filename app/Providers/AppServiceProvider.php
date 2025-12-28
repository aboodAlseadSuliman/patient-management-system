<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot() {}

    // public function boot(): void
    // {
    //     \Filament\Support\Facades\FilamentView::registerRenderHook(
    //         'panels::styles.before',
    //         fn() => \Illuminate\Support\Facades\Blade::render('
    //         <style>
    //             .fi-ta-ctn .fi-ta-header-ctn {
    //                 display: flex !important;
    //                 justify-content: space-between !important;
    //                 align-items: center !important;
    //                 gap: 1rem !important;
    //             }

    //             .fi-wi-table .fi-ta-header-toolbar {
    //                 flex: 1;
    //                 display: flex;
    //                 justify-content: space-between;
    //                 align-items: center;
    //             }

    //             .fi-ta-search {
    //                 max-width: 400px;
    //             }

    //             .fi-ta-header-heading {
    //                 margin: 0 !important;
    //             }
    //         </style>
    //     '),
    //     );
    // }
}
