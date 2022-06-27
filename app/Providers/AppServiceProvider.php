<?php

namespace App\Providers;

use App\Models\Media;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'user' => User::class,
            'profile' => Profile::class,
            'message' => Message::class,
            'media'=>Media::class
        ]);
    }
}
