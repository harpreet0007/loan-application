## Loan Application
Loan management system

The main purpose of this project is to manage loan related operations like create loan request, approval or rejection  and record installments.

task covered in this project:

 - APIs created to store loan request, get all loan request, particular request information and API to store installments.
 - Authication API provided for example register , login and All the requests are authenticated with Bearer Token Authentication
 - For Admin their is one page where admin can approve or reject loan requests after completing login process.

## Installation Instructions

- Run `composer install`
- Run `npm install`
- Run `npm run dev`
- Run `cp .env.example .env`
- Create database and update .env file with database details
- Run `php artisan migrate`
- Run `php artisan passport:install`
- Run `php artisan db:seed --class=CreateUsersSeeder`
- Run `php artisan serve`

## API Documentation
- update headers in apis to test apis with token Authorization Bearer{token} except login and register api
- [Postman Collection](https://www.postman.com/trakopteam/workspace/loan-application/collection/12769370-ee7f2724-bb3f-4778-b18c-17e5b766c6ec)

## Backend Documentation

- Admin Login Page URL => http://localhost:8000/login
    - login details =>
        - email = admin@gmail.com
        - password = 123456

- Loan Requests Page URL => http://localhost:8000/getLoans

## Testing

- Unit tests
  - Url testing perfomed  with laravel unit testing module
- Feature tests
  - All APIs testing cases perfomed with laravel feature testing module
- Update .env.testing file with database details before test cases
- Run below mention command to test all cases 
  - Run `php artisan test`

## Third-party Packages Used

- [Laravel Passport](https://laravel.com/docs/passport)
- [Laravel UI](https://larainfo.com/blogs/laravel-8-authentication-with-laravel-ui)
