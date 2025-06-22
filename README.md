# FindMate

A modern Job Application System built with **Laravel 12**, **Inertia.js**, and **Vue.js**. This platform enables admins to manage job postings, view applications, and generate detailed reports, while users can register, apply for jobs, and interact via real-time messaging.

## Features

- User Roles: Admins, Employers, and Employees  
- Job Posting and Application  
- Real-time Chat (Laravel Reverb + Pusher)  
- Dynamic Admin Dashboard (charts, filters, exports)  
- Authentication & Authorization (OAuth2, Laravel Passport)  
- Custom Date Range Reports (Excel, PDF)  
- Stripe Payments  
- Google OAuth Login  

## Built With

- Laravel 12  
- Inertia.js  
- Vue.js 3  
- Tailwind CSS  
- Laravel Reverb  
- Pusher  
- MySQL & MongoDB  
- Stripe  
- Google OAuth2  

## Environment Configuration

**You should add your own keys in this file**

<pre>```env
APP_NAME=FindMate
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=findmate
DB_USERNAME=root
DB_PASSWORD=

MONGO_DB_CONNECTION=mongodb
MONGO_DB_URI=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=reverb
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="findmate@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=eu
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME="https"

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

STRIPE_KEY=
STRIPE_SECRET=

PASSPORT_PASSWORD_CLIENT_ID=
PASSPORT_PASSWORD_CLIENT_SECRET=
</pre>

## Installation

- git clone https://github.com/oltion63/FindMate.git
- cd FindMate
- cp .env.example .env
- composer install
- npm install
- php artisan key:generate
- php artisan migrate --seed
- php artisan queue:work --queue=queue
- php artisan storage:link
- npm run serve

## Default Credentials

- **Email and Password**          
admin@gmail.com    - admin
employer@gmail.com - password
employee@gmail.com - password


## Authors:

Ardian Imeri,
Arianit Sadriu,
Jona Mustafa,
Riga Korça,
Oltion Mustafa

Students at UBT – Faculty of Computer Science and Engineering
