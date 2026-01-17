# News Aggregator Backend (Laravel)

This project is a backend-only news aggregator built with PHP Laravel.
It fetches articles from multiple external news APIs, stores them
locally, and exposes RESTful APIs for frontend consumption.

## Features

-   Aggregates news from multiple sources
-   Stores articles in MySQL with duplicate prevention
-   RESTful APIs for listing and viewing articles
-   Search, filtering, and pagination support
-   Caching for improved performance
-   Clean architecture following SOLID principles

## Supported News Sources

-   The Guardian
-   NewsAPI
-   New York Times

## API Endpoints

### List Articles

GET /api/articles

Query Parameters: - q (search by title or description) - source (filter
by source slug) - category - author - from / to (published date range) -
per_page - page

### View Single Article

GET /api/articles/{id}

Returns the full article content with source details.

## Database

Articles are stored locally with a unique constraint on: (source_id,
external_id)

This prevents duplicate articles from the same source.

## Caching

-   Article list responses are cached based on query parameters
-   Single article responses are cached by article ID

## Setup Instructions

composer install cp .env.example .env php
artisan migrate --seed



NEWSAPI_KEY= GUARDIAN_KEY= NYTIMES_KEY= BBC_KEY=

Fetch articles:

php artisan news:fetch

## Author

RESHMA N
