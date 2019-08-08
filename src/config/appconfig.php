<?php
return [
    'target_user_model'=> 'App\User',
    'usr_provider'=> \\fe_roles\models\fe_User::class,
    'user_name_field'=>false,
    'user_password_field' => false,
    'user_remember_token_field' => false
];
?>