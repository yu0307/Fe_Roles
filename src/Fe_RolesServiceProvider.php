<?php
    namespace FeIron\Fe_Roles;
    use Illuminate\Support\ServiceProvider;
    // use Illuminate\Http\Request;
    // use Illuminate\Support\Facades\Auth;

    class Fe_RolesServiceProvider extends ServiceProvider{
        public function boot(){
            //locading package route files
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            //loading migration scripts
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            //set the publishing target path for config files. Run only during update and installation of the package. see composer.json of the package.
            $this->publishes([
                __DIR__ . '/config' => config_path('Fe_Roles'),
            ],'fe_roles_config');

            if ($this->app->runningInConsole()) {
                $this->commands([
                    commands\fe_build_UserClass::class
                ]);
            }
            // $this->registerPolicies();
            // Auth::viaRequest('CheckRoles', function ($request) {
            //     return User::where('token', $request->token)->first();
            // });
        }

        public function register(){
            //append package config files to global pool for users to customize
            $this->mergeConfigFrom(
                __DIR__ . '/config/appconfig.php',
                'fe_roles_appconfig'
            );

            // config(['auth.guards.web.provider' => 'fe_users']);
            // config([
            //     'auth.providers.fe_users' => [
            //         'driver' => 'eloquent',
            //         'model' => \FeIron\Fe_Login\models\fe_users::class,
            //     ]
            // ]);                                 
        }
    }
