<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Kelas;
use App\Policies\KelasPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Kelas::class, KelasPolicy::class);
    }
}
