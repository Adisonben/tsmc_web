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
- `php artisan app:clear-preview` for clear demo user data
- `php artisan app:set-unexpire {username}` for set a user's account to never expire if user is tsm, And set org to never expire if user account is not tsm
- `app:unlink-line {username}` for unlink user from line user id

load test by k6:
- `k6 run --vus 50 --duration 30s tests/login-test.js`

07/04/2026 load test result: 
- 20–30 users => p95 ~ 2-4s 
- 40-50 users => p95 ~ 5-7s
- 60-80 users => p95 ~ 8-12s
