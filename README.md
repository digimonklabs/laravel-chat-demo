## laravel 8 chat application

### Requirement for laravel:
- Composer version 2.4.4
- PHP version 8.0

### Follow installation steps:

Fire commands in terminal :
#####  Step : 1

```
git clone https://github.com/Ruturajsinh24/laravel-chat-app.git
```
##### Step : 2

```
cd  laravel-chat-app
```
##### Step 3

```
cp .env.example .env
```
Create db on your system and update database details in .env file
##### Step : 4

```
composer install
```
Before migration install tailwind, This two command for install tailwind css
##### Step : 5
```
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

##### Step : 6
```
php artisan migrate
```
##### Step : 7
```
php artisan db:seed --class=UserSeeder
```
- This will generate tables in db and some random dummy users to check app
- You can use any email to login from users table.
- All user's password is "password".

