# TSMC Web application (Transport Safety Manager Communication)
tools:
- Laravel >= 11.x.x
- php >= 8.2.xx
- Node >= 18.x.x
- Mysql
 
install project as :
- `composer install`
- `npm install`
- create .env file
- copy .env.example to .env file
- Create Database name `tsmc_db` or other
- config database connection in .env (such as `DB_HOST` , `DB_DATABASE` , `DB_USERNAME` , `DB_PASSWORD`)
- run `php artisan key:generate` to generate the app key.
- `php artisan migrate`
- `php artisan db:seed` for insert default admin user.

to start dev server is:
- `npm run dev`
- `php artisan serve`

Don't forget to update the .env file after pulling the project from Git.

after you install project,the default admin user is : 
- Username: `tsmcadmin`
- Password: `iddrivesadmin`


if you can not login pls go to vendor/laravel/ui/auth-backend/AuthenticatesUsers.php  and change from 
`return 'email';` 
to 
`return 'username';` 
in line 157 ( in function username()).

[NestedsetDocument](https://github.com/lazychaser/laravel-nestedset)

Command:
- `php artisan app:resetUsersPassword` for reset users's password that username is "tsmc0....." to "tsmc" + date of monday (like '23092024')
