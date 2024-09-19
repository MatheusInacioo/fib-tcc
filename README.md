## About Digistock

**Digistock** is an ERP system focused on inventory and logistics management. It is designed to streamline the operations of inventory control, product movement, and warehouse management in logistics-focused businesses.

## Setup Instructions

### Requirements

- **PHP** (version 8.3.x)
  - The `php-gd` extension is required for some features.
- **Node.js** (version 18.x or higher)
- **npm**
- **Composer**
- **Docker** (for Laravel Sail)

### Installation Steps

#### 1. Clone the Repository
Clone the project into your local machine and and run `cd digistock` in order to access the correct directory and perform the following steps.

#### 2. Copy `.env.example` to `.env`
```bash
cp .env.example .env
```

#### 3. Install Node.js (if necessary)
If Node.js is not installed, use the following command to install it via NodeSource:
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

#### 4. Install npm Packages
```bash
npm install
```

#### 5. Install Composer Dependencies
If Composer is not installed, run: 
```bash
sudo apt install composer
```
Once installed, run:
```bash
composer install
```
and 
```bash
composer update
```

#### 6. Install Laravel Sail
[Laravel Sail](https://laravel.com/docs/10.x/sail) provides a simple Docker environment for local development. Install it with:
```bash
composer require laravel/sail --dev
php artisan sail:install
```
#### 7. Generate the Application Key
To generate your application key, simply run: 
```bash
php artisan key:generate
```

#### 8. Start the Application
To start the application using Sail, run:
```bash
./vendor/bin/sail up -d
```
You can also give an shell alias to the `./vendor/bin/sail` command instead of repeatedly typing it. To do so, edit your `~/.bashrc` or `~/.zshrc` file and add the following command at the end of the file: 
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
Once done, restart your shell and run `sail up -d` instead of the full command.

#### 9. Run Database Migrations
To create the application database, run: 
```bash
./vendor/bin/sail artisan migrate
```
Or, if you aliased the command: 
```bash
sail artisan migrate
```

#### 10. Seed Database
You need to fill your database with data in order to ensure it's correct functioning. To do so, run: 
```bash
sail artisan db:seed
```
#### Additional Commands
- `sail stop` - Stops the application
- `sail start` - Starts the application (once you've runned `sail up -d`)
- `sail restart` - Restarts the apllication
