# 📦 Marketplace Product Management System  
**Developed by: M. Rabyndra Janitra Binello**  

Marketplace Product Management System is a responsive and dynamic web-based application designed to manage product inventory in an online store. It supports **user authentication, role-based authorization, and full CRUD operations** on product data, including secure image uploads. The interface includes a toggleable **light/dark mode** for a comfortable user experience.

## 🚀 Key Features  
- 🔐 **User Authentication & Authorization**: Register and login functionality.  
- 🧾 **Product Listing**: Displays all available products in a card layout.  
- 🔍 **Search Engine**: Search products by name.  
- ➕ **Add Product**: Add new products with details like name, description, price, and image.  
- ✏️ **Edit Product**: Modify existing product information.  
- 🗑️ **Delete Product**: Remove products from the system.  
- 🖼️ **Upload Product Image**: Images are stored with unique hashed filenames.  
- 🌗 **Light/Dark Mode**: Toggle between light and dark themes.

## 🛠️ Technologies Used  
- **Frontend**: HTML, Tailwind CSS, JavaScript  
- **Backend**: PHP (Native)  
- **Template Engine**: PHP Embedded  
- **Database**: MySQL 

## ⚙️ Installation and Configuration  

1. **Clone this repository**  
   ```sh
   git clone https://github.com/ElloRabyndra/MarketPlaceManagement.git
   cd repository
   ```
2. **Database Configuration**
   - Create a new database named `uts_pemweb`.
   - Import the `marketplace_pemweb.sql` file into MySQL.
3. **Edit Database Configuration**
   - Modify the `config.php` file according to your database credentials: 
   ```php
   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'uts_pemweb';
   ```
4. **Run Local Server**
   - Use XAMPP or Laragon to start `Apache` and `MySQL`. 
   - Access the website at `http://localhost/your-folder-name/.`

## 🔑 Getting Started

You have two options to start using the system:

1. **Register a new account** through the registration page.
2. **Login using the provided test account:**
   - **Username**: `ellorabyndra`
   - **Password**: `123456`

After logging in, you will be directed to the main dashboard where you can add, edit, or delete products, and toggle between light/dark mode.
