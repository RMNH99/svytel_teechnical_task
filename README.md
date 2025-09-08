Setup Instructions

1. Clone the repository and install dependencies

        git clone https://github.com/RMNH99/svytel_teechnical_task.git

2. Configure environment variables

        cp .env.example .env

edit env file

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_name
    DB_USERNAME=username
    DB_PASSWORD=password

3. Run database migrations

       php artisan migrate

4. Run queue table migration and start worke

       php artisan queue:table
       php artisan migrate
       php artisan queue:work


5. Start the localserver

        php artisan serve

example import file

[users.csv](https://github.com/user-attachments/files/22202997/users.csv)


