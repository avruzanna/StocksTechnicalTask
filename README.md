# Stock Aggregator

This project is a stock aggregator application built with Laravel. It fetches stock prices from Alpha Vantage and stores them in a MySQL database. The application also uses Redis for caching and includes a cron job to fetch stock prices periodically.

## Prerequisites

- Docker
- Docker Compose

1. Clone the repository:
    ```sh
    git clone https://github.com/avruzanna/StocksTechnicalTask.git
    cd StocksTechnicalTask
    ```
2. Create vendor 
    ```sh
    composer install
    ```    
3. Copy .env.example to .env
    ```sh
    cp .env.example .env
    ``` 
4. Environment Variables

Ensure the following environment variables are set in your .env file:

```plaintext
APP_NAME=StockAggregator
APP_ENV=local
APP_KEY=base64:rcGSsbj5RiTghwmJKk2O0oi1gwSKRxFLzJ6FhwQaHPA=
APP_DEBUG=true
APP_URL=http://localhost


DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=stocks
DB_USERNAME=root
DB_PASSWORD="stockDb#"
DB_DEBUG=true

REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=strongpassword123
REDIS_CLIENT=predis

ALPHA_VANTAGE_API_KEY=your_alpha_vantage_api_key
```

5. Build and start the Docker containers:
    ```sh
    docker compose -f 'docker-compose.yml' up -d --build 
    ```
    
## Usage

The application will be available at `http://localhost:8000`.

PhpMyAdmin will be available at `http://localhost:8080`.

    username: admin
    password: adminStockDb#


## Important Notice 1:

The cron job responsible for fetching stock prices will execute every minute. However, if you want to populate the database with stock data immediately, you can manually run the following Artisan command:

    php artisan fetch:stock-prices

## Important Notice 2:

The Alpha Vantage API has a rate limit that may restrict the number of requests you can make within a specific timeframe. To facilitate development and testing without exceeding the API limits, an example JSON response is provided in the following file:

    app/Services/mocked-api-response.json

If you want to use the real API, make sure to:

Add your Alpha Vantage API key to the .env file:

    ALPHA_VANTAGE_API_KEY=your_api_key_here

Comment out lines 20-22 in the app/Services/AlphaVantageService.php file to disable the mock response and allow real API calls.

Run 
    ```sh
    php artisan fetch:stock-prices
    ``` 
