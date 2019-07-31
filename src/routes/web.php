<?php
Route::group(['namespace' => 'FeIron\Fe_Roles\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('testGuard',function(){
        dump(Auth::guard('web')->user());
        dd(config('auth'));
    });
});
?>