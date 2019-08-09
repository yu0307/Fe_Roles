<?php
Route::group(['namespace' => '\fe_roles\Http\Controllers', 'middleware' => ['web', 'ProtectByRoles:admin']], function () {
    Route::get('testGuard',function(){
        dump(Auth::user()->Roles());
        dd(config('auth'));
    });
});


?>