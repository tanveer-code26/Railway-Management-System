# Railway Management System

## 📌 Project Overview
The **Railway Management System** is a comprehensive web-based application designed to facilitate railway reservations, ticket bookings, and passenger management efficiently. Developed using **HTML, PHP, and MySQL**, this system ensures seamless database-driven operations, enhancing user experience and administrative efficiency.

## 🚀 Key Features
### 🔹 Admin Panel
- Secure authentication for administrators
- Train schedule management
- Oversight of ticket bookings and statuses
- User information management

### 🔹 User Panel
- User registration and login functionality
- Train search and ticket booking
- Secure payment processing
- Real-time ticket status tracking

### 🔹 Database Management
- Centralized database to store train details, bookings, and user records
- Secure database connection utilizing `connect.php`

## 🛠️ Technologies Utilized
- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL

## 📂 Project Directory Structure
```
📁 Railway-Management-System
│── 📁 css                    # Stylesheets for UI
│── 📝 admin_login.html       # Admin login page
│── 📝 admin_login.php        # Admin login logic
│── 📝 admin_register.html    # Admin registration page
│── 📝 admin_register.php     # Admin registration logic
│── 📝 connect.php            # Database connection file
│── 📝 login_user.html        # User login page
│── 📝 login_user.php         # User login logic
│── 📝 make_payment.php       # Payment processing module
│── 📝 option.php             # User options interface
│── 📝 register_choice.html   # User registration selection
│── 📝 ticket_book.php        # Ticket booking functionality
│── 📝 ticket_status.php      # Ticket status checking module
│── 📝 train.html             # Train schedule interface
```

## 💾 Database Schema
### 📌 Users Table
Stores user details such as ID, name, email, and password.

### 📌 Trains Table
Contains train schedules, availability, and other essential details.

### 📌 Bookings Table
Manages ticket reservations and their respective statuses.

## 🏗️ Installation & Setup Guide
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/Railway-Management-System.git
   ```
2. Import the `database.sql` file into MySQL.
3. Configure the `connect.php` file with the appropriate database credentials:
   ```php
   $conn = mysqli_connect("localhost", "root", "", "railway_db");
   ```
4. Deploy the project on a local server (e.g., XAMPP or WAMP).

## 🤝 Contributors
- **Tanveer Singh** - [GitHub](https://github.com/tanveer-code26)

## 📜 License
This project is open-source and available under the **MIT License**.

---
This project can be further enhanced by incorporating features such as seat selection, train tracking, and real-time booking updates to improve user experience.
