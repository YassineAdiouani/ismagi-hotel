# Hotel Management System

## Project Overview
This Hotel Management System is a web-based application designed to simplify the management of hotel operations. It provides features like room booking, customer management, staff assignments, and reporting to ensure smooth and efficient operation of hotel activities. Built using Laravel, this system is robust, scalable, and easy to use.

---

## Features
- Manage room availability and bookings.
- Track customer and staff details.
- Fully responsive design for seamless access across devices.

---

## Installation and Setup

Follow the steps below to clone and set up the project on your local:

### Prerequisites
Make sure you have the following installed on your system:
- PHP (>=8.0)
- Composer
- MySQL

### Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/YassineAdiouani/ismagi-hotel.git
   cd ismagi-hotel
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Set Up Environment**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update database credentials in the `.env` file:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Create a Storage Symlink**
   ```bash
   php artisan storage:link
   ```

6. **Run Migrations and Seed Database**
   ```bash
   php artisan migrate --seed
   ```

7. **Serve the Application**
   ```bash
   php artisan serve
   ```
   The application will be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Collaborators
- **Yassine Adiouani**
- **Youssef Bounit** ([GitHub Profile](https://github.com/youssef-bounit))

---

## License
This project is licensed under the ISMAGI License. See the `LICENSE` file for details.
