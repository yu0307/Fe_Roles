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

            // instruct the system to use fe_users when authenticating.
            config(['auth.guards.web.provider' => 'fe_Role_User']);
            config([
                'auth.providers.fe_Role_User' => [
                    'driver' => 'eloquent',
                    'model' => \FeIron\Fe_Roles\models\fe_User::class,
                ]
            ]);                               
        }
    }
