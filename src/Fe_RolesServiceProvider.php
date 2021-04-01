<?php

namespace feiron\fe_roles;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Compilers\BladeCompiler;
// use feiron\fe_roles\lib\traits\fe_user_traitMixin;

class Fe_RolesServiceProvider extends ServiceProvider{
    public function boot(){
        $this->registerRouteMacros();
        
        //locading package route files
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //loading migration scripts
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        //location package view files
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'fe_roles');

        //set the publishing target path for config files. Run only during update and installation of the package. see composer.json of the package.
        $this->publishes([
            __DIR__ . '/config' => config_path('fe_roles'),
        ],'fe_roles_config');

        $this->publishes([
            __DIR__ . '/assets' => public_path('feiron/fe_roles'),
        ], 'fe_roles_assets');
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                commands\fe_BuildUserClass::class
            ]);
        }

        if (app()->resolved('frameOutlet')) {
            app()->frameOutlet->bindOutlet('Fe_FrameOutlet', new \feiron\felaraframe\lib\outlet\feOutlet([
                'view' => 'fe_roles::rolemanagementOutlet',
                'myName' => 'Role Management',
                'resource' => [
                    asset('/feiron/fe_roles/js/roleManagementControl.js'),
                    asset('/feiron/fe_roles/Choices/styles/choices.min.css'),
                    asset('/feiron/fe_roles/css/roleManagement.css'),
                    asset('/feiron/fe_roles/js/roleManagementOutlet.js')
                ]
            ]));
        }

        if (app()->resolved('UserManagementOutlet')) {
            app()->UserManagementOutlet->bindOutlet('UserManageOutlet', new \feiron\fe_login\lib\outlet\feOutlet([
                'view'=> 'fe_roles::roleassignmentOutlet',
                'myName'=>'Privilege Assignment',
                'resource'=>[
                    asset('/feiron/fe_roles/Choices/styles/choices.min.css'),
                    asset('/feiron/fe_roles/css/roleManagement.css'),
                    asset('/feiron/fe_roles/js/roleAssignment.js')
                ]
            ]));
        }

        // config('auth.providers.' . config('auth.guards.web.provider') . '.model')::mixin(new fe_user_traitMixin);

        //registering guards and providers ONLY when Authentication is needed. 
        // $this->app->resolving('auth', function ($auth) {

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

    private function registerRouteMacros(){

        \Illuminate\Routing\Route::macro('role', function ($roles = []) {
            if (!is_array($roles)) {
                $roles = [$roles];
            }
            $roles = implode('|', $roles);
            $this->middleware("ProtectByRoles:$roles");
            return $this;
        });

        \Illuminate\Routing\Route::macro('permission', function ($permission = []) {
            if (!is_array($permission)) {
                $permission = [$permission];
            }
            $permission = implode('|', $permission);
            $this->middleware("ProtectBypermission:$permission");
            return $this;
        });

        \Illuminate\Routing\Route::macro('group', function ($groups = []) {
            if (!is_array($groups)) {
                $groups = [$groups];
            }
            $groups = implode('|', $groups);
            $this->middleware("ProtectByGroup:$groups");
            return $this;
        });

        Route::aliasMiddleware('ProtectByRoles', lib\middleware\ProtectByRoles::class);
        Route::aliasMiddleware('ProtectBypermission', lib\middleware\ProtectBypermission::class);
        Route::aliasMiddleware('ProtectByGroup', lib\middleware\ProtectBypermission::class);
    }

    public function register(){
        
        //append package config files to global pool for users to customize
        $this->mergeConfigFrom(
            __DIR__ . '/config/appconfig.php',
            'fe_roles_appconfig'
        );

        if (!app()->runningInConsole()) {
            // instruct the system to use fe_users when authenticating.
            config(['auth.guards.fe_Roles' => ['driver' => 'session', 'provider' => 'fe_Role_User']]);
            config(['auth.guards.web.provider' => 'fe_Role_User']);
            config([
                'auth.providers.fe_Role_User' => [
                    'driver' => 'eloquent',
                    'model' => (config('fe_roles_appconfig.usr_provider') ? config('fe_roles_appconfig.usr_provider') : (\feiron\fe_roles\models\fe_User::class)),
                ]
            ]);
        }

        $this->registerBladeDir();           
    }

    private function registerBladeDir(){
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            
            $bladeCompiler->if('role', function ($roles) {
                $roles = is_array($roles) ? $roles : explode(',', $roles);
                return (auth()->check() && auth()->user()->HasRole($roles));
            });

            $bladeCompiler->if('permission', function ($permissions) {
                $permissions = is_array($permissions) ? $permissions : explode(',', $permissions);
                return (auth()->check() && auth()->user()->UserCan($permissions) );
            });

            $bladeCompiler->if('group', function ($groups) {
                $groups = is_array($groups) ? $groups : explode(',', $groups);
                return (auth()->check() && auth()->user()->FromGroup($groups));
            });
        });
    }
}
