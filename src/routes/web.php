<?php
Route::group(['namespace' => '\fe_roles\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('testGuard',function(){
        dump(Auth::guard('web')->user());
        dd(config('auth'));
    });
});
?>