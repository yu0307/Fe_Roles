<?php

Route::get('testGuard',function(Request $request){
    Auth::check();
    dd(Auth::user());
    FeIron\Fe_Roles\models\fe_roles::find(1)->user()->first();
    dd(config('Fe_Roles.appconfig.target_user_model'));
    dd(config('fe_roles_config'));
    dd(config('auth'));
    return 'HI';
});

?>