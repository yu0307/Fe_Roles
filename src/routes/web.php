<?php

Route::get('testGuard',function(){
    dd(config('fe_roles_appconfig'));
    dd(config('auth'));
    return 'HI';
});

?>