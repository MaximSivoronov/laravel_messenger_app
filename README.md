# Real-time chat on Laravel 9 and Vue 2.

## Frameworks:

- `Laravel 9.11.0`
- `Vue 2.6`

## Libraries:

- `Axios`
- `Pusher-js`
- `Laravel echo`

## Database:

- `SQLITE`

## What he can do:

- Working in real-time with pusher-js and laravel echo;
- Send messages;
- Read messages;
- Sorting contacts by count of unread messages;
- Shows how many messages you don't read yet from each contact.

## What he can't do yet (Hope I will add this later):

- Edit messages;
- Delete messages.

## What I learn by doing this project:

- How make real-time app with use WebSockets like pusher-js;
- Work with events in vue;
- Not obvious and complex SQL queries.

## How to launch project on your local machine:

1. Clone the repository.
2. Using command line run `composer install`.
3. Then run `npm i` or `npm install`.
4. Create `.env` file and copy inside all from `.env.example` file.
5. Set up your database (in my case it was sqlite), and run `php artisan migrate`.
6. Add new entries for users and messages tables manually, or use `php artisan db:seed` command (you also can change count of users and messages in `Database\Seeders\DatabaseSeeder.php` file).
7. Run `php artisan serve` and `npm run dev` or `npm run watch`.
