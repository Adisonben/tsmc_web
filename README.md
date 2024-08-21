# TSMC Web application (Transport Safety Manager Communication)
 
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
