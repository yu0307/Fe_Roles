<?php
Route::group(['namespace' => 'feiron\fe_roles\http\controllers', 'middleware' => [ 'web' ]], function () {
    Route::get('rolemanagement','RoleManagement@show')->name('Fe_RoleManagement');

    Route::post('roleCRUD','RoleManagement@list')->name('Fe_RoleCRUD');
    Route::post('roleCRUD/save','RoleManagement@save')->name('Fe_RoleCRUD_save');
    Route::post('roleCRUD/delete/{ID}','RoleManagement@delete')->name('Fe_RoleCRUD_delete')->where('ID', '[0-9]+');
    Route::post('roleCRUD/{ID}','RoleManagement@load')->name('Fe_RoleCRUD_load')->where('ID', '[0-9]+');
    Route::post('roleCRUD/abilities','RoleManagement@ListAbilities')->name('Fe_ListAbilities');
    Route::post('roleCRUD/roles', 'RoleManagement@ListRoles')->name('Fe_ListRoles');
    Route::post('roleCRUD/GetUserAbilities/{UID}', 'RoleManagement@ListUsrAbilities')->name('Fe_ListUsrAbilities')->where('UID', '[0-9]+');
    Route::post('roleCRUD/PriAssign/{UID}', 'RoleManagement@AssignUsr')->name('Fe_AssignUsrPrivilege')->where('UID', '[0-9]+');

});

?>