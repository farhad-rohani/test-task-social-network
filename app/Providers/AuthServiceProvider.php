<?php

namespace App\Providers;

use App\Models\Media;
use App\Models\Message;
use App\Models\Profile;
use App\Policies\MediaPolicy;
use App\Policies\MessagePolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Message::class => MessagePolicy::class,
        Profile::class => ProfilePolicy::class,
        Media::class => MediaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
