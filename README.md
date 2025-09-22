# 🛒 BeyBey E-Commerce Platform

BeyBey is a comprehensive e-commerce platform built with PHP and JavaScript. It leverages modern web technologies to provide a seamless shopping experience for users and a robust management interface for administrators.

## ✨ Features

- **Product Management**: Add, edit, and delete products with ease.
- **Category Management**: Organize products into categories.
- **Stock Management**: Keep track of product inventory.
- **Image Handling**: Upload and manage product images.
- **Responsive Design**: Optimized for both desktop and mobile devices.

## 🛠️ Technologies Used

- **Backend**: PHP
- **Frontend**: JavaScript, Vue.js
- **Package Managers**: npm, Composer
- **Styling**: Tailwind CSS
- **Routing**: Inertia.js with Laravel `web.php` for backend routing

## 🚀 Installation

### Prerequisites

- PHP 7.4 or higher
- Node.js and npm
- Composer

### Steps

1. **Clone the repository**:
    ```sh
    git clone https://github.com/ItsTimonExe/BeyBey.git
    cd BeyBey
    ```

2. **Install PHP dependencies**:
    ```sh
    composer install
    ```

3. **Install JavaScript dependencies**:
    ```sh
    npm install
    ```

4. **Set up environment variables**:
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

5. **Run database migrations**:
    ```sh
    php artisan migrate
    ```

6. **Build the frontend assets**:
    ```sh
    npm run dev
    ```

7. **Start the development server**:
    ```sh
    php artisan serve
    ```

## 📸 Demo

Take a look at some screenshots of BeyBey in action!

| Homepage | Shop Page | Product Page |
|----------|--------------|-------------|
| <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image1.jpg" alt="Homepage Screenshot" width="300" /> | <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image2.jpg" alt="Product List Screenshot" width="300" /> | <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image3.jpg" alt="Admin Panel Screenshot" width="300" /> |

| Cart Page | Login Page | Admin Panel |
|----------|--------------|-------------|
| <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image4.jpg" alt="Homepage Screenshot" width="300" /> | <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image6.jpg" alt="Product List Screenshot" width="300" /> | <img src="https://raw.githubusercontent.com/ItsTimonExe/BeyBey/master/Image8.jpg" alt="Admin Panel Screenshot" width="300" /> |


## 📖 Usage

- **Admin Panel**: Manage products, categories, and stock.
- **User Interface**: Browse products, add to cart, and checkout.

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## 📄 License

This project is licensed under the MIT License.
