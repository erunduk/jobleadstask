## Introduction

Once upon a time I have applied to a JobLeads Job. Spent some time running tests and interview. Now, after small pause it happened to spent some more time applying. To make this time fun & usefull I have decided to deep into something more-or-less new for me. So, even if my job application will fail, I will at least get the new experience solving the task. Some time ago I started learning & using Laravel in production, wrote one small project. I realy like Laravel, it is very nice especially for backend development. Currently the only thing I think is not good enough is forms data submission validation (I find Yii2 validation system better), well, who knows, maybe later I will change my opinion as I will get more experience.

## Setup

Instruction assumes PHP is correctly setup on the machine with  all required components. So, in brief...

To install composer dependencies, we need to run:
> composer install

Create & edit your own copy of settings file (we need to set a correct MySQL DB connection settings here):
> cp .env.example .env

> vim .env

Now, when steps above are done, run this two commands to build DB  structure and to fill the DB with some sample data:
>php artisan migrate

>php artisan db:seed

Some more small preparations:
>php artisan key:generate

>php artisan config:cache

And, finally, to run the application, execute:
>php artisan serve

Now, when everything works and you can see the web application pages in your browser, you can log in using my contact email address as login and phrase `passowrd` as a password. Logging in will allow you to access protected area where you can modify some data.

Enjoy!

