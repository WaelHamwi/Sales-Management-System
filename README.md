# Getting Started
Follow these steps to set up and run the project on your local machine.
# Laravel Project

## Demo
To see a live demo of the project, visit ```http://https://drive.google.com/drive/folders/1wWmqyxOrmpT5t_hgVsQFvEOLLHU3KxVH```.

## Prerequisites
Make sure you have the following installed on your machine:
* PHP (version 8.1.28)
* Composer
* Node.js (version 20.12.2)
* npm
* Git

## Clone the Repository
```git clone https://github.com/WaelHamwi/semiramis.git```

## Navigate to the Project Directory
```cd semiramis```

## Install Dependencies
You need to install the dependencies for both PHP and Node.js.

Install PHP dependencies using Composer:
```composer install```

Install Node.js dependencies using npm:
```npm install```

## Create a Copy of the Environment File
```cp .env.example .env```

## Generate Application Key
```php artisan key:generate```

## Configure Database
Update the `.env` file with your database credentials.

## Run Migrations
```php artisan migrate```

## Start the Development Server
```php artisan serve```

Alternatively, you can follow these steps to use Apache instead of `php artisan serve`:

### Configure Apache Virtual Host
Open your Apache configuration file, usually located at `conf/extra/httpd-vhosts.conf` in your XAMPP installation directory. Add a virtual host entry for your Laravel project:
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/semiramis/public"
    ServerName semiramis.dv
</VirtualHost>

## Update Hosts File
Add an entry to your hosts file to map the domain to your localhost:
127.0.0.1    semiramis.dv


Hosts file location: `C:\Windows\System32\drivers\etc\hosts`

The application will be accessible at ```http://semiramis.dv/```.
=======
=======
>>>>>>> main
# Sales-Management-System

A robust Sales Management System built with Laravel for the backend and AJAX with jQuery/JavaScript for the frontend, featuring secure user authentication, customer and product management, real-time data updates, and comprehensive reporting tools to enhance sales efficiency and user experience.

## Google Drive Folder
-you can click on the link below to watch a demo of the project:
[Sales-Management-System](https://drive.google.com/drive/folders/1wWmqyxOrmpT5t_hgVsQFvEOLLHU3KxVH?usp=drive_link)

## Key Features

### User Authentication 
- Secure user login and registration

### Sales Management
- Create, update, and track sales orders
- Real-time inventory updates

### Product Management
- Manage product catalog
- Track product stock levels
- Product categorization and search functionality

### Reporting and Analytics
- Sales performance dashboards
- Customizable reports (e.g., daily, monthly, yearly sales)

## Technologies Used

### Backend
- **Laravel**
  - Web-based data management
  - Eloquent ORM for database operations
  - Blade templating engine for server-side rendering (where applicable)

### Frontend
- **AJAX, jQuery, JavaScript**
  - Asynchronous data fetching for a responsive user experience
  - Dynamic content updates without page reloads
  - jQuery for DOM manipulation and event handling

### Database
- **MySQL**
  - Structured data storage and management
  - Complex queries for reporting and analytics

### Additional Tools
- Composer for dependency management
- npm for managing frontend dependencies
- Bootstrap for responsive design
  
### UML ERD Diagram
- Designed an Entity-Relationship Diagram (ERD) to model the database structure and relationships
  
## Benefits
- **Efficiency**: Streamlined sales processes and real-time data updates improve productivity.
- **User Experience**: A responsive and intuitive interface enhances user satisfaction.
- **Scalability**: The system is designed to handle increasing data and user load.
- **Security**: Role-based access control and secure authentication protect sensitive information.
- **Insightful Reporting**: Comprehensive analytics and reporting tools aid in strategic decision-making.

## Conclusion
This Sales Management System project showcases a full-stack web development application using modern technologies, emphasizing both functionality and user experience. It demonstrates proficiency in backend and frontend development, database management, and the implementation of dynamic, data-driven features.
<<<<<<< HEAD

=======

