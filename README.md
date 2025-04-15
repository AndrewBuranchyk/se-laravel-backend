# S.E. Dashboard

## Setting up
### 1. Installing all the dependencies
```sh
composer install
```

### 2. Copying Env File
```sh
cp .env.example .env
```

### 3. Copying SQLite Database File if the "database.sqlite" doesn't exist
```sh
cp database/database.sqlite.example database/database.sqlite
```

### 4. Building and seeding the database
    SQLite is used as default database so for Windows OS in php.ini should be first uncommented the following line "extension=pdo_sqlite".
    If you use Ubuntu OS you should install PHP SQLite3 extension: apt-get -qy install php8.3-sqlite3
```sh
php artisan migrate:fresh --seed
```
    After that seeding there are the following test users:
    - admin@test.com (with "admin" role)
    - usersAdmin@test.com (with "usersAdmin" role)
    - viewOnly@test.com (with "viewOnly" role)
    - user@test.com (with "user" role)
    The password for all test users is "123456" (you can change it in UserFactory.php on line 35)


## Running the Server
### During development
```sh
php artisan serve 
```
    INFO Server running on [http://127.0.0.1:8000].


### After the production deployment running the FrankenPHP server
    FrankenPHP is a Modern PHP App Server, written in Go.
```sh
php artisan --no-interaction octane:frankenphp --workers=4 --max-requests=250 --port=8080 
```


## Running the Tests
### Running all feature tests
```sh
php artisan test --testsuite=Feature 
```

### Running a specific test
```sh
php artisan test --filter=YourTestClassName 
```


## Deployment to AWS Lambda using Bref
    Bref comes as an open source Composer package and helps you deploy PHP applications to AWS and run them on AWS Lambda. 
    AWS has a generous free tier that will usually allow you to deploy your first serverless applications for free.
### 1. AWS Preparation
    - Go to https://aws.amazon.com/ and log in to your account
    1. In the AWS dashboard, go into IAM and create a new user: https://us-east-1.console.aws.amazon.com/iamv2/home#/users/create
    2. Set a user name (for example "bref-cli") and move to the next screen
    3. Click Attach policies directly, search for AdministratorAccess and select it, then click Next
    4. Once your user is created, select it and go to Security credentials
    5. Scroll down to Access Keys and click on Create access key
    6. Then select Command Line Interface
    7. Add a description to your access keys and click on Create access key

### 2. Install Serverless framework CLI using NPM
```sh
npm install -g serverless@3
```

### 3. Setup keys gained from AWS using Serverless CLI:
```sh
serverless config credentials --provider aws --key "key" --secret "secret"
```

### 4. Install Brief and Laravel-Brief packages
```sh
composer require bref/bref bref/laravel-bridge --update-with-dependencies
```

### 5. Create serverless.yml configuration file
```sh
php artisan vendor:publish --tag=serverless-config
```

### 6. Prepare the project for deployment by removing unnecessary cache and dependencies
```sh
php artisan config:clear
```
```sh
composer install --prefer-dist --optimize-autoloader --no-dev
```

### 7. Deploy
```sh
serverless deploy
```
    When finished, the deploy command will show the URL of the application.



## Deployment to Azure App Service directly from the Azure Repos
    Could be completely free of payment
### 1. Creating Azure App Service
    - Sign in to your https://portal.azure.com/
    - In the search bar tap "App Services" and go to App Services
    - Click on the "Create" dropdown and select "Web App", fill out the form as follows:
    1. Resource Group - select "Create new" and enter "se-laravel-backend"
    2. Name - enter "se-laravel-backend"
    3. Publish - select "Code"
    4. Runtime stack - select "PHP 8.3"
    5. Region - select "Germany West Central"
    6. Linux Plan ... - select "... F1"
    7. Pricing plan - should be "Free F1 (Shared infrastructure)"
    8. Click Review + create
    9. Click Create

### 2. Configuring the Startup commands and SCM Basic Auth
    - Go to App Service "se-laravel-backend"
    - From the left menu, select "Configuration"
    - In the General settings tab:
    1. In the Startup Command box, enter the following command:
    /home/site/wwwroot/azure-startup.sh
    2. Turn on the "SCM Basic Auth Publishing Credentials"
    3. Click on the "Save" button

### 3. Configuring the Deployment
    - Go to App Service "se-laravel-backend"
    - From the left menu, select "Deployment Center"
    - In the General settings tab fill out the form as follows:
    1. Source - select "Azure Repos"
    2. Organization - select "aburanchik"
    3. Project - select "se"
    4. Repository - select "se-laravel-backend"
    5. Branch - select "master"
    6. Click on the "Save" button

### 4. Checking the service
    - Go to App Service "se-laravel-backend"
    - From the left menu, select "Overview"
    - Click on the "Browse" button and then should open the page "https://se-laravel-backend.azurewebsites.net/"


## Deployment to Azure App Service using Azure Pipelines
    Before you need to purchase at least one "Parallel job" service in the Project Settings of the Azure DevOps
### 1. Creating Azure App Service
    - Sign in to your https://portal.azure.com/
    - In the search bar tap "App Services" and go to App Services
    - Click on the "Create" dropdown and select "Web App", fill out the form as follows:
    1. Resource Group - select "Create new" and enter "se-laravel-backend"
    2. Name - enter "se-laravel-backend"
    3. Publish - select "Code"
    4. Runtime stack - select "PHP 8.3"
    5. Region - select "Germany West Central"
    6. Linux Plan ... - select "... F1"
    7. Pricing plan - should be "Free F1 (Shared infrastructure)"
    8. Click Review + create
    9. Click Create

### 2. Creating a pipeline for deploying to the created App Service
    Before you need to Purchase at least one "Parallel job" service in the Project Settings
    - Sign in to your Azure DevOps https://dev.azure.com/
    - Go to Pipelines, and click on Create Pipeline
    - When prompted, select "Azure Repos Git"
    - When the list of repositories appears, select "se-laravel-backend"
    - When new pipeline appears, take a look at the YAML and 
    from azure-pipelines.yml.example copy all exept azureSubscription (it should be fresh). 
    When you're ready, click on " Save and Run".
    - When Build stage is complited you need to add permission to deploy it.
    It appears the following message: "This pipeline needs permission to access a resource before this run can continue to Deploy"
    - Click on "View" button and then the "Permit" button.

### 3. Checking the service
    - Go to App Service "se-laravel-backend"
    - From the left menu, select "Overview"
    - Click on the "Browse" button and then should open the page "https://se-laravel-backend.azurewebsites.net/"


## Commands log during the development
### 1. Installing Laravel 11 
    SQLite will be as default database so in php.ini should be uncommented "extension=pdo_sqlite"
```sh
composer create-project laravel/laravel s21-backend 
```

### 2. Installing Laravel Sanctum.
    Laravel Sanctum is only concerned with managing API tokens and authenticating existing users using session cookies or tokens (for SPAs ...). 
    Sanctum does not provide any routes that handle user registration, password reset, etc.
```sh
php artisan install:api
```
```sh
php artisan migrate
```

### 3. Customizing the CORS configuration
```sh
php artisan config:publish cors
```

### 4. Installing Laravel Fortify.
    Fortify provides routes that handle user login, registration, password reset, email verification, etc
```sh
composer require laravel/fortify
```
```sh
php artisan fortify:install
```
```sh
php artisan migrate
```

### 5. Installing Laravel Socialite.
    Socialite provides authentication with OAuth via Facebook, X, LinkedIn, Google, GitHub, GitLab, Bitbucket, and Slack
```sh
composer require laravel/socialite
```
    Set Up Google OAuth Credentials:
    - Go to the Google Cloud Console - https://console.cloud.google.com/
    - Create a new project (e.g., "Laravel-React-Auth")
    - Navigate to APIs & Services > Credentials and Click Create Credentials > OAuth 2.0 Client IDs
    - Select Web Application as the application type
    - Add Authorized JavaScript Origins (e.g., https://localhost:5173/ for React)
    - Add Authorized Redirect URIs (e.g., https://localhost:5173/auth/google/callback - for React)
    - Save to .env file the Client ID and Client Secret

### 6. Installing Octane.
    Octane serving the app using high-powered application servers, including FrankenPHP ... 
    Octane boots the app once, keeps it in memory, and then feeds it requests at supersonic speeds.
```sh
composer require laravel/octane
```

### 7. Installing FrankenPHP (only on Linus OS)
    FrankenPHP is a Modern PHP App Server, written in Go, that supports modern web features like early hints, Brotli, and Zstandard compression.
```sh
php artisan octane:install --server=frankenphp
```

