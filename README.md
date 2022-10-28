## Occupational Health Service Demo Web App

This is a simple [Occupational Health Service](https://en.wikipedia.org/wiki/Occupational_safety_and_health) demo web software licensed under the [MIT license](https://opensource.org/licenses/MIT) and built with the following technologies:

- [Laravel](https://laravel.com/) - a popular and extensive PHP framework known for its elegant syntax.
- [SQLite](https://www.sqlite.org/index.html) - a C-language library that implements a small, fast, self-contained, high-reliability, full-featured, SQL database engine.
- [Livewire](https://laravel-livewire.com/) - a full-stack framework for Laravel that takes the pain out of building dynamic UIs.
- [AlpineJS](https://alpinejs.dev/) - a new, lightweight, JavaScript framework.
- [Tailwind CSS](https://tailwindcss.com/) - a utility-first CSS framework that gives you the tools and the standardization to build exactly what you want.
- 
### Installation instructions

```
git clone git@github.com:plamen911/occupational-health-service.git
cd occupational-health-service/
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --port=3000
```

Open your browser and go to: [http://localhost:3000/](http://localhost:3000/)

Press Control + C keys to stop the server.
