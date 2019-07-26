<?php

Route::get('testGuard',function(){
    $test=FeIron\Fe_Roles\models\fe_roles::find(1)->hasAbilities();
    dd(DB::getQueryLog());
    dd(config('fe_roles_appconfig'));
    dd(config('auth'));
    return 'HI';
});

?>