# Reste-App

Reste-app is a website for managing restaurant reservations, built using the Laravel framework and customized with styles from the Tailwind template. With Reste-app, restaurant admins can easily add, update, and delete categories, menu items, tables, and reservations, all from a simple and intuitive admin panel. For regular users, Reste-app makes it easy to view restaurant information, browse the menu, and make reservations with just a few clicks.

## Features

-   Admin panel for managing categories, menu items, tables, and reservations
-   Frontend for regular users to view restaurant information and make reservations
-   Customized frontend using styles from the Tailwind template
-   Validation checks in place to ensure data integrity

## Installation

To install and run Reste-app on your local machine, follow these steps:

1. Clone the GitHub repository to your local machine.
2. In the project root directory, run composer install to install the necessary dependencies.
3. Create a new database and update the .env file with your database credentials.
4. Run `php artisan migrate` to run the database migrations.
5. Run `php artisan serv` to start the local development server.
6. Visit http://localhost:8000 in your web browser to view the website.

## Usage

### Admin Panel

To access the admin panel, navigate to http://localhost:8000/admin. You will be prompted to log in with your admin credentials.

Once logged in, you can perform the following CRUD operations:

-   Categories: Add, update, and delete categories.
-   Menu Items: Add, update, and delete menu items.
-   Tables: Add, update, and delete table information.
-   Reservations: Add, update, and delete reservations.

### Frontend

To access the regular user frontend, navigate to http://localhost:8000. From here, you can view restaurant information, browse the menu, and make reservations.

To make a reservation, click the "Make Reservation" button and enter your information, including the desired reservation date and time, and the number of guests. The website will then display a list of available tables based on your reservation time and the number of guests.

## Future Improvements

Here are some potential future improvements for Reste-app:

-   Mobile Optimization: Optimize the website for mobile devices to make it even more accessible to users on the go.
-   Analytics: Add analytics tools to the admin panel to track reservations and customer data.
-   Payment Integration: Integrate payment systems to allow users to pay for reservations online.

## Credits

Reste-app was built by [Mahmoud Sayed](https://github.com/MahmoudSayedA/). The project was developed using the Laravel framework and customized with styles from the Tailwind template. Special thanks to the Laravel and Tailwind communities for their support and resources.

## License

Reste-app is open-source software [licensed under the MIT license.](LICENSE)
