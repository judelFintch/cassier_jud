# Incident Management Portal

This repository contains a Laravel application used to record and analyse incidents. The project uses the **Jetstream** starter kit with the **Livewire** stack to provide authentication and account management features.

## Main Features

- **Incident CRUD** – create, view, update and delete incidents with associated officers.
- **Geolocation Map** – display incidents on an interactive Leaflet map sourced from OpenStreetMap tiles.
- **Statistics Dashboard** – visualise crime trends using Chart.js (incidents by type and by day).
- **API Endpoints** – JSON endpoints for map data and dashboard statistics protected by Laravel Sanctum.

## Tools & Technologies

- PHP 8.2 and Laravel 12
- [Laravel Jetstream](https://jetstream.laravel.com) with Livewire
- Tailwind CSS and Vite for frontend assets
- Chart.js for rendering graphs
- Leaflet for mapping

## Getting Started

Clone the repository and install the dependencies:

```bash
composer install
npm install
```

Create your `.env` file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

Run the database migrations (optionally seed sample incidents):

```bash
php artisan migrate --seed
```

Finally, build the frontend assets and start the development server:

```bash
npm run dev
php artisan serve
```

You can now access the application at `http://localhost:8000`.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

