# Cactu Pachanoi - Correspondence Application

## About Cactu Pachanoi

Cactu Pachanoi is a fictional correspondence application designed for a non-profit organization dedicated to helping at-risk children in Ecuador. This application enables donors and sponsors to establish personalized connections with the children by sending and receiving letters, photos, and messages of support.

## Key Features:

-   Secure and fast digital correspondence sending and receiving.
-   Intuitive interface for creating letters, attaching images, and sending - inspiring messages.
-   Automatic translation option to facilitate communication between donors and children.
-   Privacy and data security for children and donors guaranteed.

Join Cactu Pachanoi and be part of the positive change in the lives of at-risk children. Together, we can make a difference!

## Getting Started

1. Let's install composer using bellow command:
    ```sh
    composer install
    ```
2. Next, we will copy .env from .env.example for configuration so let's run bellow command:

    ```sh
    cp .env.example .env
    ```

3. Now you can update database configuration on that file as like bellow:

    ```.env
    DB_DATABASE=cactu_demo
    DB_USERNAME=demo
    DB_PASSWORD=demo123456
    ```

4. Next, we will generate key using bellow command:

    ```sh
    php artisan key:generate
    ```

5. Now, it's optional command. you can run migration and seeder command as like bellow:
    ```sh
    php artisan migrate
    ```
    or
    ```sh
    php artisan migrate:fresh
    ```
    optional
    ```sh
    php artisan db:seed
    ```

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Pablo Guerra via [pablo.guerra@espoch.edu.ec](mailto:pablo.guerra@espoch.edu.ec) or [josegr.lopez@espoch.edu.ec](mailto:josegr.lopez@espoch.edu.ec). All security vulnerabilities will be promptly addressed.

## License

The Cactu Line is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
