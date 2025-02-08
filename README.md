# BeyBey E-commerce Platform

BeyBey is an e-commerce platform built with Vue.js for the frontend and PHP for the backend. This project aims to provide a seamless shopping experience with features like product browsing, cart management, and user authentication.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Contributing](#contributing)
- [License](#license)

## Installation

### Prerequisites

- Node.js
- npm
- PHP
- Composer

### Steps

1. Clone the repository:
    ```sh
    git clone https://github.com/ItsTimonExe/BeyBey.git
    cd BeyBey
    ```

2. Install frontend dependencies:
    ```sh
    cd BeyBey
    npm install
    ```

3. Install backend dependencies:
    ```sh
    composer install
    ```

4. Set up environment variables:
    ```sh
    cp .env.example .env
    # Update .env with your configuration
    ```

5. Run the development server:
    ```sh
    npm run dev
    ```

## Usage

- Navigate to `http://localhost:3000` to view the application.
- Use the navigation bar to browse products, add items to the cart, and manage your account.

## Features

- **Product Browsing**: View and search for products.
- **Cart Management**: Add, remove, and update items in the cart.
- **User Authentication**: Login and register users.
- **Responsive Design**: Optimized for both desktop and mobile devices.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
