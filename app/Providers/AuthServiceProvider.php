<?php

namespace App\Providers;
use App\Models\Submission;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-submission', function ($user, Submission $submission) {
            return $user->id === $submission->user_id;
        });
    
        Gate::define('update-submission', function ($user, Submission $submission) {
            return $user->id === $submission->user_id;
        });
    
        Gate::define('delete-submission', function ($user, Submission $submission) {
            return $user->id === $submission->user_id;
        });
    }
}
