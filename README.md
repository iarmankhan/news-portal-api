# News Portal API

Fetch news from API and provide REST API to access those news

## Pre-requisites

- Docker
- Docker Compose
- NodeJS

## Installation

1. Clone the repository
2. Run following command to install dependencies
    ```bash
    docker run --rm --interactive --tty \
      --volume $PWD:/app \
      --user $(id -u):$(id -g) \
      composer install
    ```

3. Run following command to start the server
    ```bash
    ./vendor/bin/sail up
    ```

4. Run following command to run migrations
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

5. Copy `.env.example` to `.env`

    ```bash
    cp .env.example .env
    ```

6. Update `NEWSAPI_KEY` in `.env` file with your API key (Get API key from https://newsapi.org/)

    ```bash
    NEWSAPI_KEY=<your_api_key>
    ```

7. Run following command to fetch news from API

    ```bash
    ./vendor/bin/sail artisan app:fetch-news <category>
    ```

8. Application will be available at http://localhost:8080

## API Documentation

1. Register user
    
    ```bash
    curl --request POST \
      --url http://localhost:8080/api/auth/register \
      --header 'Content-Type: application/json' \
      --data '{
        "name": "John Doe",
        "email": "john+doe@test.com",
        "password": "password",
        "password_confirmation": "password"
    }'
    ```

2. Login user

    ```bash
    curl --request POST \
      --url http://localhost:8080/api/auth/login \
      --header 'Content-Type: application/json' \
      --data '{
        "email": "john+doe@test.com",
        "password": "password"
    }'
    ```

3. Get all news

    ```bash
    curl --request GET \
        --url 'http://localhost:8080/api/news?category=technology&page=1&search=query' \
        --header 'Content-Type: application/json' \
        --header 'Authorization: Bearer <access_token>'
    ```
