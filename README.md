# Stock Aggregator

This project is a stock aggregator application built with Laravel. It fetches stock prices from Alpha Vantage and stores them in a MySQL database. The application also uses Redis for caching and includes a cron job to fetch stock prices periodically.

## Prerequisites

- Docker
- Docker Compose

1. Clone the repository:
    ```sh
    git clone https://github.com/yourusername/stock-aggregator.git
    cd stock-aggregator
    ```
    
2. Build and start the Docker containers:
    ```sh
    docker-compose up --build
    ```
    
## Usage

The application will be available at `http://localhost:8000`.


## Environment Variables

Ensure the following environment variables are set in your .env file:

```plaintext
APP_NAME=StockAggregator
APP_ENV=local
APP_KEY=base64:random_app_key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=stocks
DB_USERNAME=admin
DB_PASSWORD=adminStockDb#

REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=strongpassword123
REDIS_CLIENT=predis

ALPHA_VANTAGE_API_KEY=your_alpha_vantage_api_key
```

## Important Notice 1:

The cron job responsible for fetching stock prices will execute every minute. However, if you want to populate the database with stock data immediately, you can manually run the following Artisan command:
    ```sh
    php artisan fetch:stock-prices
    ```
## Important Notice 2:

The Alpha Vantage API has a rate limit that may restrict the number of requests you can make within a specific timeframe. To facilitate development and testing without exceeding the API limits, an example JSON response is provided in the following file:

    app/Services/mocked-api-response.json

If you want to use the real API, make sure to:

Add your Alpha Vantage API key to the .env file:

    ```sh
        ALPHA_VANTAGE_API_KEY=your_api_key_here
    ```
Comment out lines 20-22 in the app/Services/AlphaVantageService.php file to disable the mock response and allow real API calls.


