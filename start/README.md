### tech stack

- **backend:** PHP 8.x (Laravel)
- **database:** PostgreSQL (via AWS RDS in production)
- **cache/rate limiting:** Redis (via AWS ElastiCache in production)
- **authentication:** JWT (php-open-source-saver/jwt-auth)
- **containerization:** Docker
- **cloud:** AWS (RDS, ElastiCache, API Gateway, CloudWatch)

### features

- JWT-based staff authentication
- role-based access control (Admin, Staff, Scanner)
- guest registration with auto-generated ticket codes
- gift redemption with database transaction locks to prevent race conditions
- double redemption prevention
- real-time inventory tracking with low stock alerts
- redis caching to reduce database load
- API rate limiting per endpoint
- redemption history and CSV export reports


### requirements
- PHP 8.x, composer, docker desktop


### installation

1. clone repo
```bash
git clone https://github.com/yourusername/hwwc-ticketing.git
cd hwwc-ticketing
```

2. install dependencies
```bash
composer install --prefer-dist
```


3. start Docker containers
```bash
docker compose up -d
```


4. start the server
```bash
php artisan serve
```