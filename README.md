# 📦 Marketplace Product Management System  
**Developed by: M. Rabyndra Janitra Binello**  

The Marketplace Product Management System is a web-based application for managing product inventory in an online store. This application supports CRUD (Create, Read, Update, Delete) operations and stores product images with unique filenames.

## 🚀 Key Features  
- **View Product List**: Display a list of available products.  
- **Add Product**: Add new products with complete details.  
- **Edit Product**: Update product information.  
- **Delete Product**: Remove products from the database.  
- **Upload Product Images**: Save images with unique filenames in the `uploads/` folder.  

## 🛠️ Technologies Used  
- **Frontend**: HTML, Tailwind CSS, JavaScript  
- **Backend**: PHP (Native)  
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

