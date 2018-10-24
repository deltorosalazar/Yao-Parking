<p align="center"><img src="http://i1122.photobucket.com/albums/l530/Pipetit96/f50f5667-88d4-45fc-8874-058cd13957ba.png"></p>

# YaoParking

Project presented by Manuel F. Del Toro to simulate the operations of 100 parkings.

## Installation Process

### MacOS

- Clone the project
- Install the dependencies

```
php artisan serve
```

- Install Redis Database using Homebrew

```
brew install redis
```

- Run Redis

```
brew services start redis
```

- Configure a MySQL database
- Change your MySQL credentials and Redis port in the .env file
- Start the Laravel server

```
php artisan serve
```

- In some occassions your would have to change the port

```
php artisan serve --port 9876
```
