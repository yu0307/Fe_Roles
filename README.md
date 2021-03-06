## Welcome to Fe_Roles Repo
### **Recommended to be used with [LaraFrame](https://github.com/yu0307/LaraFrame)**
### Let's collaborate!
Email me for bugs, feature suggestions,pull requests,etc... or even hang out :) [yu0307@gmail.com](mailto:yu0307@gmail.com)
### This package allows users to 
- Protect route by Permission or Role
- Protect contents by Permission or Role
- Protect route and contents by middlewares
- Manage list of Permissions or Roles
- Extend functionalities of Permission and Role management

### Dependencies:
- Composer [Visit vendor](https://getcomposer.org/)
- PHP 7+
- Laravel 5+

### Installation:

1. Please make sure composer is installed on your machine. For installation of composer, please visit [This Link](https://getcomposer.org/doc/00-intro.md)
2. Once composer is installed properly, please make sure Larave is up to date. 
3. Navigate to your project root directory and run the following command to install Fe_Roles
    ```
    composer require FeIron/Fe_Roles
    ```
4. This package is going to publish several files to the following path
    - config/fe_roles/
    - public/feiron/fe_roles/
5. **Important!** This package is also going to perform several migrations. Please refer to the following changes and make backups of your tables if they are present. 
6. **Since I can't seem to have package auto publish assets**. make sure you run the following command at the end and every updates of this package. 

    ```
        php artisan vendor:publish --provider="feiron\fe_roles\Fe_RolesServiceProvider" --force
        php artisan migrate --path="/vendor/feiron/fe_roles/src/database/migrations/"
        php artisan db:seed --class=\feiron\fe_roles\database\seeder\RoleSeeder
        php artisan Build:BuildUserClass
    ```

    **Important!** Command "Build:BuildUserClass" is ran to modify the user proivider class needed for the system. It modified the class(feiron\fe_roles\models\fe_User.php) to inherit from the user provider class the system is currently using. This package will force the system to use class(feiron\fe_roles\models\fe_User.php), therefore, we need to have the class inherit from the current user class. 

    You can also instruct the system to use other user provider classes by making changes to the config file (/config/fe_roles/appconfig.php) and modify the (target_user_model) parameter. 

7. Seeding is also performed at the end of the migrations to create some stock permissions and roles. 
    ```
    Schema to be Created/Modified
    [fe_roles]:
    id bigint(20) UN AI PK 
    name varchar(191) 
    description varchar(191) 
    rank int(11) 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ------------------------------------------
    [fe_abilities]:
    id bigint(20) UN AI PK 
    name varchar(191) 
    description varchar(191) 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ------------------------------------------
    [fe_abilities_targets]:
    ability_id bigint(20) UN PK 
    target_id varchar(36) PK 
    target_type varchar(50) PK 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ------------------------------------------
    [fe_role_targets]:
    role_id bigint(20) UN PK 
    target_id varchar(36) PK 
    target_type varchar(50) PK 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ------------------------------------------
    [fe_role_abilities]:
    role_id bigint(20) UN PK 
    ability_id bigint(20) UN PK 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ------------------------------------------
    [fe_groups]:
    id bigint(20) UN AI PK 
    name varchar(191) 
    description varchar(191) 
    disabled tinyint(1) 
    created_at timestamp 
    updated_at timestamp
    ```
**Note**: During migration, if you encounter error showing "Specified key was too long"
This was due to MySQL version being older than 5.7.7, if you don't wish to upgrade MySQL server, consider the following.

Within your AppServiceProvider 
    ```
    use Illuminate\Support\Facades\Schema;

    /**
    * Bootstrap any application services.
    *
    * @return void
    */

    public function boot()
    {
        Schema::defaultStringLength(191);
    }
    ```
Further reading on this could be found at [This Link](https://laravel.com/docs/master/migrations#creating-indexes)


### Basic Usage:

**note:** You can create your own user provider class by either inherit from \feiron\fe_roles\models\fe_User.php or simply use trait "feiron\fe_roles\lib\traits\fe_user_traits" in your current user provider class.

1. Protecting Routes:
    **note** multiple role/permission names can be seperated by "|". 
    - Chain methods (role,permission,etc) in route definitions:
    ```
        Route::get('test', 'controller@method')->name('routename')->role("admin|editor");
    ```
    - Use middleware(ProtectByRoles,ProtectBypermission,etc) and pass in list of checks as parameters:
    ```
        Route::get('test', 'controller@method')->name('routename')->middleware('ProtectByRoles:admin|editor');
    ```
    Or in a controller definition:
    ```
        class testController extends Controller{

            public function __construct()
            {
                $this->middleware('ProtectBypermission:admin|editor')->except('logout');
            }
        }
    ```
2. Protecting Contents:
    within blade files, use the following directives to check for access levels:
    ```
        ...

        General visible contents ...
        @role([admin,editor])
            this is protected by role admin and editor.
        @endrole

        @permission(read)
            this is protected to those who can read.
        @endpermission

        ...
    ```

### configuration:

**Important**. There is a configuration file being published to /config/fe_roles/appconfig.php. Proper configuration is required. 
Sample config:
```
return [
    'target_user_model'=> 'App\User',
    'usr_provider'=> \feiron\fe_roles\models\fe_User::class,
    'user_name_field'=> false,
    'user_password_field' => false,
    'user_remember_token_field' => false
];
```
Explainations:

| option name | Values | Description | Default |
| --- | --- | --- | --- |
| target_user_model | string | Model class used by the system to handel user storage. | required |
| usr_provider | string | Class file used by the system user and guard provider. | required |
| user_name_field | string | Table field name used to store user names. | false |
| user_password_field | string | Table field name used to store user passwords. | false |
| user_remember_token_field | string | Table field name used to store user expiration tokens. | false |

### Permission/Role Management Feature
This package provides many useful permission/role management features along with the ability to extend management feature. 

### **Manage user roles and permission is enabled with the use this package jointly with [LaraFrame](https://github.com/yu0307/LaraFrame) and [Fe_Login](https://github.com/yu0307/Fe_Login).**

## LaraFrame Support
This package was tailored to work with [LaraFrame](https://github.com/yu0307/LaraFrame).
- Permission/Role management is easily done through the shared control panel/interface provided by the framework. 
- Permission/Role information can be jointly managed under user profile.
- Manage user permission and roles made easy with the framework.
- Outlets are automatically carried into the framework and making permission/role information related management a breeze. 

## Support us:

If you like this project, Please, please, please consider put a Star⭐️ and tweet about it.

I would love for any forms of supports and they are deeply appreciated👍! Thanks!