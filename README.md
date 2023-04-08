# Bus Booking System

This is a bus booking system built using Laravel Framework 10.6.2. The system allows users to book trips between 2 stations that cross over in-between stations.



## Installation

1. Clone the repository to your local machine.
2. Install the required dependencies using Composer by running composer install.
```bash
composer install
```
*note :
You may need to update your composer version as I have used Laravel Framework 10.6.2. You can update it using composer self-update.
```bash
composer self-update
```

3. Create a new database for the project and update the .env file with the database credentials.
4. Run the migrations and seed the database with sample data by running php artisan migrate --seed.
```bash
php artisan migrate --seed
```
6. Start the development server by running php artisan serve.
```bash
php artisan serve
```


## Usage

- You can find postman collection [HERE](https://api.postman.com/collections/16929431-f0ce838a-703c-4a3e-b5e9-b2dd93ebb05d?access_key=PMAT-01GXHDPKV9PV5K55VN9WN62SWQ) to test the APIs.
- As required there is an Authentication in the system. you can register a new user or login using these credentials if you ran the migrations :
 
- Email : john@example.com
- Password : password

## Notes
- The system assumes that there is a single bus for each trip.
- The user can book only one seat.
- List of available seats: return a list of the trips and their available seats that fit the request start-end station.
