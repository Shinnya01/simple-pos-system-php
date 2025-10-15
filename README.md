# Simple PHP Point of Sale (POS) System

A basic, file-based Point of Sale system built with plain PHP, designed for managing products, tracking sales, and simple reporting.

---

## 🚀 Getting Started

These instructions will help you set up and run the POS system on your local machine.

### Prerequisites

You need a local environment that can run PHP and handle SQLite database files:
* **PHP** (version 7.0+ recommended)
* A web server (e.g., **Apache** or **Nginx**)
* A combined package like **XAMPP**, **WAMP**, or **MAMP** is highly recommended for quick setup.

### Installation

1.  **Clone or Download:**
    ```bash
    git clone https://github.com/Shinnya01/simple-pos-system-php.git
    cd layout
    ```
2.  **Server Setup:**
    Place all project files into your web server's document root (e.g., `htdocs` or `www` folder).
3.  **Database Initialization:**
    This system uses **SQLite** (`database.sqlite`). The file **`setup_db.bat`** is provided to initialize the database structure (tables for products, sales, users, etc.).
    * **Windows:** Simply double-click `setup_db.bat`.
    * **Other OS:** You will need to inspect the contents of `setup_db.bat` and run the equivalent database setup commands using your PHP/SQLite CLI.
4.  **Configuration:**
    Review the **`.env`** and **`config.php`** files to adjust any system-wide settings, especially for security or paths.
5.  **Access the System:**
    Open your web browser and navigate to the project's URL (e.g., `http://localhost/index.php`). The first step is usually to **`login.php`**.

---

## 💻 System Modules & File Structure

The application separates core functionality into different files, making it easy to maintain.

| Directory/File | Purpose in a POS System |
| :--- | :--- |
| **`assets/`** | Static files: `style.css` for visual design, `shop.png` perhaps for the logo or product images. |
| **`pages/products.php`** | The main **Sale Screen** where transactions are processed. |
| **`pages/manage_products.php`** | **Inventory Management** interface for adding, editing, or deleting items. |
| **`pages/my_purchases.php`** | Customer view of past transactions (or a simple sales history report). |
| **`pages/manage_users.php`** | **User Management** for POS operators (e.g., Cashiers, Admins). |
| **`db.php` / `database.sqlite`** | Database handler and the central data store for sales, inventory, and users. |
| **`login.php` / `logout.php`** | Secure access for cashiers and administrators. |
| **`layout.php` / `sidebar.php`** | The common structure and navigation for the POS interface. |

---

## ✨ Core POS Features

* **Product Management:** Add, edit, and delete products with prices and stock levels.
* **Transaction Processing:** The main sales interface for ringing up items.
* **Reporting:** Basic sales tracking via `my_purchases.php`.
* **Authentication:** Secure login for POS operators.

---

## 🔑 Default Credentials

* **Username:** (Look in `setup_db.bat` or `db.php` for initial data setup)
* **Password:** (Look in `setup_db.bat` or `db.php` for initial data setup)

***NOTE:*** *It is highly recommended to change the default admin credentials immediately after setup.*

---

## ⚖️ License

This project is licensed under the **MIT License** - see the `LICENSE.md` file for details.