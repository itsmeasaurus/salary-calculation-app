<?php

namespace App\Providers;

use App\Repositories\MemberRepository;
use App\Repositories\MemberRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot(): void
    {
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
    }
}
