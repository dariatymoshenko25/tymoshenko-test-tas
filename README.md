## Getting Started:
1. Copy environment file : cp .env.example .env
2. Build and start containers: docker compose up -d --build
3. Install PHP dependencies: docker compose exec app composer install
4. Generate Laravel application key: docker compose exec app php artisan key:generate
5. Run migrations: docker compose exec app php artisan migrate
6. Create storage symlink: docker compose exec app php artisan storage:link 
7. Build frontend assets: docker compose exec vite npm install and then ->  docker compose exec vite npm run build
8. Access the application: http://localhost:8000
## Important:
Only files strictly less than 10MB are considered valid for upload. Files with a size of 10MB or greater are not accepted and are considered out of scope for this task.
## Possible Improvements
Bulk file deletion (delete multiple files at once)
Send batch messages to the queue instead of dispatching one message per file
Implement user authentication
