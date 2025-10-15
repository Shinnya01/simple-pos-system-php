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

### 🌐 Local Domain Setup (Optional)

    To access your project using a clean URL like `http://myshop.local` instead of `http://localhost/project-folder/`, you need to edit your system's hosts file:

1.  **Open Notepad as Administrator:**
    * Search for "Notepad" in the Start Menu.
    * Right-click and select "Run as administrator."

2.  **Open the Hosts file:**
    * In Notepad, go to **File > Open**.
    * Navigate to this location:
        ```
        C:\Windows\System32\drivers\etc\hosts
        ```
    * (Make sure the file filter is set to "All Files" to see the `hosts` file.)

3.  **Add the mapping:**
    Add the following line to the bottom of the file:
    ```
    127.0.0.1    myshop.local
    ```

4.  **Save and Close:**
    Save the `hosts` file and close Notepad.

### 🗄 Database Initialization

Initialize the SQLite database (`database.sqlite`) by running the setup script from your terminal:

```bash
.\setup_db.bat

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