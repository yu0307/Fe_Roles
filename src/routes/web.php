<?php
Route::group(['namespace' => '\fe_roles\Http\Controllers', 'middleware' => [ 'web', 'ProtectByRoles:admin' ]], function () {

    Route::get('testGuard',function(){
        dd(config('auth'));
    })->permission('read');
    
});


?>