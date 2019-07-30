<?php
Route::group(['namespace' => 'FeIron\Fe_Roles\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('testGuard',function(){
        // dd(
        //     FeIron\Fe_Roles\models\fe_roles::all()->RoleAbilities()->get()
        // );
        dd(
            FeIron\Fe_Roles\models\fe_User::find(1)->RoleAbilities());
        // dd(get_class(Auth::user()));
        // dd(Config::get('auth'));
        // FeIron\Fe_Roles\models\fe_roles::find(1)->user()->first();
        // dd(config('Fe_Roles.appconfig.target_user_model'));
        // dd(config('fe_roles_config'));
        // dd(config('auth'));
        // return 'HI';
    });
});
?>