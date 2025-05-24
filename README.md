
# Laravel + Vue + Docker Starter Guide 🐳

This is a starter setup for Laravel 10 with Vue 3 using Vite and Docker (PHP + MySQL). It covers local development and deployment preparation.

## Docker start and stop commands
```bash
# Start Docker containers
docker-compose up -d --build
# Stop Docker containers
docker-compose down -v
``` 

---  
## 🛠 Setup and Usage

1. **Clone and enter the project directory**  
   `git clone https://your-repo-url.git && cd laravue-dashboard`

2. **Start Docker containers**  
   `docker-compose up -d --build`  
   This runs:
- Laravel on `http://localhost:8000`
- MySQL on `localhost:3306`

3. **Install Laravel dependencies**
```bash  
docker exec -it laravue-dashboard bash  
composer install  
cp .env.example .env  
php artisan key:generate  
php artisan migrate  
exit
```  
4. Install and run Vite (Vue frontend)  
On your host machine:  
```bash  
npm install  
npm run dev  
```  
If using Docker on Linux, update .env:  
VITE_APP_URL=http://192.168.x.x:5173  
(Use the actual IP from Vite output)

5. Start Laravel dev server (if not automated)
```
docker exec -it laravue-dashboard bash
php artisan serve --host=0.0.0.0 --port=8000
```
6.  **Ensure correct Vite config** (`vite.config.js`)

```js
export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 5173,
    hmr: {
      host: '192.168.x.x' // or 'host.docker.internal'
    }
  }
})
```
7. If you see blank pages or `0.0.0.0` in browser

-   Delete `public/build/hot`

-   Restart Vite: `npm run dev`

-   Update `.env` with correct `VITE_APP_URL`

-   Clear Laravel cache:
```bash
        `php artisan config:clear && php artisan optimize:clear`
```

Preparing for Production
1.  **Build frontend assets**  
`npm run build`

2.  **Remove `public/build/hot` if it exists**

3.  **Ensure `.env` has:**

```    
APP_ENV=production
APP_DEBUG=false` 
```    
4.  Use a proper web server (not `php artisan serve`) like nginx or Apache.

5.  Do not run `npm run dev` in production – use built files only.

6.  Serve Laravel from the `public/` directory


----------

## ✅ Deployment Checklist

-   Docker containers build without errors

-   Laravel `.env` is configured for production

-   `npm run build` completed

-   `public/build/hot` is deleted

-   Assets load without 0.0.0.0 references

-   Laravel served via nginx or Apache (not artisan serve)


----------

## 🔧 Common Issues

-   **Blank page** → Vite not running or `public/build/hot` has wrong host

-   **0.0.0.0 in script src** → Set correct `VITE_APP_URL` and restart Vite

-   **Port conflict** → Kill old processes (`lsof -i :5173`)

-   **Config not applying** → Run `php artisan config:clear`
