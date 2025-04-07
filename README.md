# Filament Starter-kit

Welcome to the **Filament API Starter-kit** project! This repository is designed to enhance your Laravel application with powerful features and seamless integration.

---

## Getting Started

1. **Clone the repository**:
    ```bash
    git clone https://github.com/sayrgyiwoody/filament-api-starter-kit.git
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**:
    ```bash
    npm install
    ```

4. **Build frontend assets**:
    ```bash
    npm run build
    ```

5. **Configure your `.env` file and run migrations**:
    ```bash
    php artisan migrate --seed
    ```

6. **Start the queue worker to handle jobs**:
    ```bash
    php artisan queue:listen
    ```

7. **Start the Reverb service for real-time features**:
    ```bash
    php artisan reverb:start
    ```

---

## License

This project is licensed under the [MIT License](LICENSE).
