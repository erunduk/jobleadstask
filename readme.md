## Introduction


Once upon a time I have applied to a JobLeads Job, spent some time running tests and interview. 
Now, after small pause, we seem to talk again. To make some use of this time, I have decided to deep into something more-or-less new for me.
So, even if my job application will fail, I will at least get the new experience solving the task. 
Some time ago I have started learning & using Laravel in production, wrote one small production project. 
I really like Laravel, it is very nice especially for backend development. 
This repository contains the results of my work. 
Please, review it and let me know when it will be not needed anymore - I plan to drop it once it will be not needed anymore.


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

