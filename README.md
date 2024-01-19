## How to Use

### Clone the repository

> git clone **https://github.com/Kirolos-Victor/iphone-photography-assessment**

### Install Via Composer

> composer install

### Generate Application Key

> php artisan key:generate

### Setup your .env file

> Rename .env.example to .env and modify the configuration to match your local machine.

### Run the database migrations (Set the database connection in .env before migrating)

> run **php artisan migrate**

### Testing

> run **php artisan test** for checking the test cases

### Task

> Create a new user using the seeders **php artisan db:seed** and then use this endpoint to: **/api/users/1/achievements**

> **About the task**: It follows Laravel best practices, emphasizing Object-Oriented Programming (OOP) and incorporating design patterns like Observer, Event and Listeners, Services, and Actions.
> 
> the system allows for dynamic changes in badge and achievement numbers without affecting overall functionality.
> 
> Explicit data types are used for clarity and compatibility,
> 
> the code follows PSR-12 formatting for consistency and readability.
>
> I hope my approach to the task didn't come across as overly engineered. My goal was to highlight my solid understanding of Laravel architecture without making things more complicated than necessary.