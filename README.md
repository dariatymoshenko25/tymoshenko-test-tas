## Getting Started:
1. Build and start containers: docker compose up -d --build app
2. Build frontend assets: docker compose exec vite npm run build
3. Run migrations: docker compose exec app php artisan migrate
4. Create storage symlink: docker compose exec app php artisan storage:link
5. Access the application: http://localhost:8000
## Important:
Only files strictly less than 10MB are considered valid for upload. Files with a size of 10MB or greater are not accepted and are considered out of scope for this task.
## Possible Improvements
Bulk file deletion (delete multiple files at once)
Send batch messages to the queue instead of dispatching one message per file
Implement user authentication
