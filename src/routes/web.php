<?php

Route::get('testGuard',function(){
    
    dd(config('auth'));
    return 'HI';
});

?>