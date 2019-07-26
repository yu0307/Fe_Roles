<?php
Route::group(['namespace' => 'FeIron\Fe_Roles\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('testGuard',function(){
        // dump(config('auth'));
        // config(['auth.guards.web.provider' => 'fe_users']);
        // config([
        //     'auth.providers.fe_users' => [
        //         'driver' => 'eloquent',
        //         'model' => FeIron\Fe_Login\models\fe_users::class,
        //     ]
        // ]);
        // config(['auth.passwords.users' => ['provider' => 'fe_users', 'table' => 'password_resets', 'expire' => 120]]);
        // dd(config('auth'));
        
        // dd(get_class($this->app['auth']));
        dd(Config::get('auth'));
        // FeIron\Fe_Roles\models\fe_roles::find(1)->user()->first();
        // dd(config('Fe_Roles.appconfig.target_user_model'));
        // dd(config('fe_roles_config'));
        // dd(config('auth'));
        // return 'HI';
    });
});
?>