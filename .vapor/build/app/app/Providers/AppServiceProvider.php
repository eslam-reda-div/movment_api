<?php

namespace App\Providers;

use App\Models\Company;
use App\Observers\CompanyObserver;
use App\Policies\ActivityPolicy;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as AuthServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Spatie\Health\Checks\Checks\BackupsCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\FlareErrorOccurrenceCountCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\MeiliSearchCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\RedisMemoryUsageCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(lang_path('dashboard'), 'dashboard');

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->displayLocale(app()->getLocale())
                ->locales(['en_us', 'ar'])
                ->labels([
                    'en_us' => 'English',
                    'ar' => 'العربية',
                ]);
        });

        // app()->setFallbackLocale('en');

        $this->registerPolicies();
        $this->loadPolicies();

        Gate::policy(Activity::class, ActivityPolicy::class);
        Company::observe(CompanyObserver::class);

        Health::checks([
            //            BackupsCheck::new(),
            CacheCheck::new(),
            DatabaseCheck::new(),
            DatabaseConnectionCountCheck::new(),
            DatabaseSizeCheck::new(),
            DatabaseTableSizeCheck::new(),
            DebugModeCheck::new(),
            //            EnvironmentCheck::new(),
            //            FlareErrorOccurrenceCountCheck::new(),
            //            HorizonCheck::new(),
            //            MeiliSearchCheck::new(),
            OptimizedAppCheck::new(),
            PingCheck::new()->url(env('APP_URL')),
            QueueCheck::new(),
            //            RedisCheck::new(),
            //            RedisMemoryUsageCheck::new(),
            ScheduleCheck::new(),
            //            UsedDiskSpaceCheck::new(),
        ]);

        Gate::define('view-mailweb', function ($user) {
            return $user->can('page_MailHistory');
        });

        // Global Gate check
        Gate::before(function ($user, $ability) {
            // Super admin check for admin guard
            if (auth()->guard('admin')->check()) {
                if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
                    return true;
                }

                return null;
            }

            // Company guard always has full access
            if (auth()->guard('company')->check()) {
                return true;
            }

            return null;
        });
    }

    /**
     * Load all policies from the Policies directory
     */
    private function loadPolicies(): void
    {
        $policiesPath = app_path('Policies');

        if (! File::isDirectory($policiesPath)) {
            return;
        }

        $files = File::allFiles($policiesPath);

        foreach ($files as $file) {
            $policyClass = 'App\\Policies\\'.str_replace('.php', '', $file->getFilename());

            if (! class_exists($policyClass)) {
                continue;
            }

            $modelName = str_replace('Policy', '', $file->getFilename());
            $modelClass = 'App\\Models\\'.str_replace('.php', '', $modelName);

            if (class_exists($modelClass)) {
                Gate::define($modelClass.'-*', function ($user, $ability) use ($policyClass) {
                    // Company guard always has access
                    if (auth()->guard('company')->check()) {
                        return true;
                    }

                    // For admin guard, use the original policy
                    $policy = new $policyClass;
                    if (method_exists($policy, $ability)) {
                        return $policy->$ability($user);
                    }

                    return false;
                });
                $this->policies[$modelClass] = $policyClass;
            }
        }

        // Register the policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}