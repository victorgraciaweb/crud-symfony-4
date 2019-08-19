How to run?
--

1. Install dependencies 
    
    `composer install`

2. Run the project 
    
    `php bin/console server:run`  

3. Open in browser 

    http://127.0.0.1:8000/


How to configure?
--

1. For to connect your MYSQL database, change in .env file:

       DATABASE_URL=mysql://root@127.0.0.1:3306/<DB_NAME>

2. For to generate MYSQL database and tables, you need writing in a terminal, in root project:

       php bin/console doctrine:database:create
       
       php bin/console make:migration

       php bin/console doctrine:migrations:migrate


3. For configurate your JWT in .env file, you need to change it: 

        JWT_SECRET=<YOUR_SECRET_KEY>