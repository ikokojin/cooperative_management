<?php

namespace App\Providers;

use App\Models\lending_program_tbl;
use App\Observers\LendingProgramObserver;
use App\View\Composers\NavbarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        lending_program_tbl::observe(LendingProgramObserver::class);

        View::composer('components.navbar2', NavbarComposer::class);
    }
}
