<?php
    namespace feiron\fe_roles;
    use Illuminate\Support\ServiceProvider;
    // use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

class Fe_RolesServiceProvider extends ServiceProvider{
    public function boot(){
        //locading package route files
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //loading migration scripts
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        //set the publishing target path for config files. Run only during update and installation of the package. see composer.json of the package.
        $this->publishes([
            __DIR__ . '/config' => config_path('fe_roles'),
        ],'fe_roles_config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                commands\fe_build_UserClass::class
            ]);
        }

        // $this->app->bind('\fe_roles\models\fe_User', function ($app) {
        //     return new \fe_roles\models\fe_User();
        // });
        

        //registering and using custom user provider
        // Auth::provider('fe_user_provider', function ($app, array $config) {
        //     return new \fe_roles\models\fe_user_provider($app->make('\fe_roles\models\fe_User'));
        // });


        // registering and using custom guards
        // Auth::extend('fe_RoleCheck', function ($app, $name, array $config) {
        //     return new models\fe_role_guard($name, Auth::createUserProvider($config['provider']), $this->app['session.store'], $this->app->make('request'));
        // });

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
        // config(['auth.guards.fe_Roles' => ['driver'=> 'session','provider'=>'fe_Role_User']]);
        config(['auth.guards.web.provider' => 'fe_Role_User']);
        config([
            'auth.providers.fe_Role_User' => [
                'driver' => 'eloquent',
                'model' => (config('fe_roles_appconfig.usr_provider') ? config('fe_roles_appconfig.usr_provider') : (\feiron\fe_roles\models\fe_User::class)),
            ]
        ]);                 
    }
}
