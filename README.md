# E-Waste-Shop
## A Web based Information System for Managing an E-Waste Shop

## Introduction

This project, E-WasteHub, develops an online platform for inventory management in the electronics market. Its purpose is to reduce electronic waste (e-waste) and promote sustainability by connecting sellers of refurbished electronics with potential buyers. The platform addresses the problem of toxic environmental hazards caused by e-waste by using advanced inventory systems to track stock levels accurately, reducing excess inventory and waste from unsold electronics.

## Dependencies

For the following system, it requires the following technologies:
- Laravel framework
- PHP (8.2 or higher)
- Composer
- Apache server or XAMPP
- Preferred IDE
- Jetstream
- DOMPDF Wrapper for Laravel

## Installation
In order to install PHP click [here](https://www.php.net/downloads) and as for [composer](https://getcomposer.org) click on the link.

### Install Laravel

After you have installed PHP and Composer, you may create a new Laravel project via Composer's create-project command:
```

composer create-project laravel/laravel example-app

```
Or, you may create new Laravel projects by globally installing the Laravel installer via Composer:
```
composer global require laravel/installer
 
laravel new example-app
```
Once the project has been created, start Laravel's local development server using Laravel Artisan's serve command:
```
cd example-app
 
php artisan serve
```
Once you have started the Artisan development server, your application will be accessible in your web browser at http://localhost:8000. 

### Install Jetstream

Install Jetstream With Livewire ​

```
php artisan jetstream:install livewire
```

If you would like "teams" support, you can provide the --teams directive to the install command:

```
php artisan jetstream:install livewire --teams
```

Or, Install Jetstream With Inertia ​

```
php artisan jetstream:install inertia
```

If you would like "teams" support with the Inertia stack, provide the --teams directive to the install command:

```
php artisan jetstream:install inertia --teams
```

Dark Mode ​

If you would like to include "dark mode" support when scaffolding your application's frontend, provide the --dark directive when executing the jetstream:install command:

```
php artisan jetstream:install livewire --dark
```

Finalizing the Installation ​

After installing Jetstream, you should install and build your NPM dependencies and migrate your database:

```
npm install
npm run build
php artisan migrate
```
### Install DOMPDF Wrapper for Laravel
Require this package in your composer.json and update composer. This will download the package and the dompdf + fontlib libraries also.
```
composer require barryvdh/laravel-dompdf
```
#### Using
You can create a new DOMPDF instance and load a HTML string, file or view name. You can save it to a file, or stream (show in browser) or download.
```
    use Barryvdh\DomPDF\Facade\Pdf;
    $pdf = Pdf::loadView('frontend.order.order_invoice', compact('order','orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
    ]);
    return $pdf->download('invoice.pdf');
```



## Usage
1. Clone the repo and cd into it
2. In your terminal `composer install`
3. Rename or copy `.env.example` file to `.env`
4. `php artisan key:generate`
5. Set your database credentials in your .env file 
6. Import db file(database/e_waste_shop.sql) into your database (mysql,sql)
7. `npm install`
8. `npm run watch`
9. Edit .env file :- remove APP_URL
10. `php artisan serve` or use virtual host
11. Visit `localhost:8000` in your browser
12. Visit /admin if you want to access the admin panel. Admin Email/Password: `admin@gmail.com`/`12345678`. User Email/Password: `user@gmail.com`/`12345678`


## Project Structure

```
E_WASTE_SHOP-SYSTEM                           
├── app                         # Core application code
│   ├── Actions                 # Custom actions for business logic
│   ├── Console                 # Artisan commands
│   ├── Events                  # Event classes
│   ├── Exceptions              # Exception handling
│   ├── Http                    # Controllers, middleware, requests
│   ├── Models                  # Eloquent models
│   ├── Providers               # Service providers
│   └── View                    # View components
├── artisan                     # Artisan CLI script
├── bootstrap                   # Framework bootstrap files
│   ├── app.php                 # Bootstrap the application
│   └── cache                   # Cached files for performance
├── composer.json               # Composer dependencies configuration
├── composer.lock               # Locked versions of Composer dependencies
├── config                      # Configuration files
│   ├── app.php                 # Application configuration
│   ├── auth.php                # Authentication configuration
│   ├── cache.php               # Cache configuration
│   ├── database.php            # Database configuration
│   ├── fortify.php             # Fortify configuration (security)
│   ├── hashing.php             # Password hashing configuration
│   ├── jetstream.php           # Jetstream configuration (auth)
│   ├── logging.php             # Logging configuration
│   ├── mail.php                # Mail configuration
│   ├── session.php             # Session configuration
│   └── view.php                # View configuration
│   └── …                
├── database                    # Database-related files
│   ├── factories               # Model factories for testing
│   ├── migrations              # Database migrations
│   └── seeders                 # Database seeders
├── lang                        # Localization files
├── node_modules                # Node.js dependencies
├── package-lock.json           # Locked versions of Node.js dependencies
├── package.json                # Node.js dependencies configuration
├── phpunit.xml                 # PHPUnit configuration for testing
├── postcss.config.js           # PostCSS configuration
├── public                      # Publicly accessible files (assets)
├── reset_password.sh           # Script for resetting passwords
├── reset_password.sh.save      # Backup of the reset password script
├── resources                   # Views, raw assets, and language files
├── routes                      # Route definitions
├── storage                     # File storage (logs, uploads, etc.)
├── tailwind.config.js          # Tailwind CSS configuration
├── tests                       # Automated tests
├── vendor                      # Composer dependencies
└── vite.config.js              # Vite configuration for frontend assets
├── README.md                   # Project overview and instructions


```

## License
E-WasteHub is completely free and released under the [MIT license](https://opensource.org/licenses/MIT).














