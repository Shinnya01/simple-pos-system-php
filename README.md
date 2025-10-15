# Simple PHP Point of Sale (POS) System

A basic, file-based **Point of Sale (POS)** system built with plain PHP, designed for managing products, tracking sales, and simple reporting. It uses a **SQLite** database for a quick, dependency-free setup.

---

## 🚀 Getting Started

These instructions will help you set up and run the POS system on your local machine.

### Prerequisites

You need a local server environment capable of running PHP and handling SQLite:
* **PHP** (version 7.0+ recommended)
* A web server (e.g., **Apache** or **Nginx**)
* A unified package like **XAMPP**, **WAMP**, or **MAMP** is highly recommended.

### Installation

1.  **Clone or Download:**
    ```bash
    git clone [https://github.com/Shinnya01/simple-pos-system-php.git](https://github.com/Shinnya01/simple-pos-system-php.git)
    cd layout
    ```
2.  **Server Setup:**
    Place all project files into your web server's document root (e.g., the `htdocs` or `www` folder in your server package).

---

### 🌐 Local Domain Setup (Optional)

To access your project using a clean URL like `http://myshop.local` instead of a standard `localhost` path, you can edit your system's hosts file:

1.  **Open Notepad as Administrator:**
    * Search for "Notepad" in the Start Menu, right-click, and select "Run as administrator."

2.  **Open the Hosts file:**
    * In Notepad, go to **File > Open**.
    * Navigate to the following path (you may need to change the file filter to "All Files"):
        ```
        C:\Windows\System32\drivers\etc\hosts
        ```

3.  **Add the Mapping:**
    Add the following line to the bottom of the file:
    ```
    127.0.0.1    myshop.local
    ```

4.  **Save and Close:**
    Save the `hosts` file and close Notepad.
    *(Note: If you use a custom domain, you will also need to configure your web server (e.g., Apache VirtualHost) to serve the project from `myshop.local`.)*

---

### 🗄 Database Initialization & Final Run

1.  **Initialize the Database:**
    The system uses **SQLite** (`database.sqlite`). Run the setup script from your project's root directory in the terminal:
    ```bash
    .\setup_db.bat
    ```

2.  **Access the System:**
    Open your web browser and navigate to the project's URL. The system will direct you to the login screen first.

    * **Using Local Domain:** `http://myshop.local`
    * **Using Localhost:** `http://localhost/index.php` (or replace `/index.php` with your project's folder name if necessary)

---

## 💻 System Modules & File Structure

The application separates core functionality into different files for easy maintenance.

| Directory/File | Purpose in a POS System |
| :--- | :--- |
| **`assets/`** | Static files: `style.css` for visual design, `shop.png` for branding/logo. |
| **`pages/products.php`** | The main **Sale Screen** where transactions are processed. |
| **`pages/manage_products.php`** | **Inventory Management** interface for adding, editing, or deleting items. |
| **`pages/my_purchases.php`** | Simple **Sales History/Report** view. |
| **`pages/manage_users.php`** | **User Management** for POS operators (e.g., Cashiers, Admins). |
| **`db.php` / `database.sqlite`** | Database handler and the central data store for sales, inventory, and users. |
| **`login.php` / `logout.php`** | Secure access for cashiers and administrators. |
| **`layout.php` / `sidebar.php`** | The common structure and navigation for the POS interface. |

---

## ✨ Core POS Features

* **Inventory Management:** Add, edit, and delete products with prices and stock levels.
* **Transaction Processing:** The main sales interface for ringing up items.
* **Reporting:** Basic sales tracking via `my_purchases.php`.
* **Authentication:** Secure login for POS operators.

---

## 🔑 Default Credentials

* **Username:** (Check `setup_db.bat` or `db.php` for initial setup data)
* **Password:** (Check `setup_db.bat` or `db.php` for initial setup data)

***NOTE:*** *It is highly recommended to change the default admin credentials immediately after setup for security.*

---

## ⚖️ License

This project is licensed under the **MIT License** - see the `LICENSE.md` file for full details.