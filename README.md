# Server Manager

## Project Overview

Server Manager is a Laravel 12 + Livewire 3.5+ web application designed to manage websites hosted on a server. It provides a user-friendly interface for creating and managing websites, handling PHP versioning, DNS records, GitHub repository integration, automated deployments, and server monitoring. The application is built with a focus on security, maintainability, and extensibility, leveraging modern PHP, Livewire, Tailwind CSS, daisyUI, and best practices in Laravel development.

**Infrastructure Stack:**
- **Web Server:** FrankenPHP - A modern, high-performance web server written in Go that embeds PHP directly, providing better performance than traditional Apache/Nginx + PHP-FPM setups
- **Caching:** Redis for session storage, caching, and queue management
- **Database:** MySQL/PostgreSQL/SQLite for persistent data storage
- **Process Management:** Supervisor for managing FrankenPHP processes and ensuring high availability

---

## Project Goals

- **Website Management:** Allow users to create, configure, and manage multiple websites on a server.
- **PHP Version Control:** Enable users to select and update supported PHP versions for each website, ensuring security and compatibility.
- **DNS Management:** Provide tools to manage DNS records for each website, facilitating domain assignment and access.
- **GitHub Integration & Deployment:** Allow users to link GitHub repositories, automate deployments on branch updates, and run post-deployment scripts (e.g., Tailwind/JS builds).
- **Server Metrics Monitoring:** Offer real-time monitoring of server health and resource usage.
- **Testing & Code Quality:** Ensure robust test coverage with PestPHP and maintain code quality with PHPStan.

---

## Core Features & Steps

### 1. Website Management
- [ ] Livewire component for website CRUD (create, read, update, delete)
- [ ] Form to specify website name, domain, and initial configuration
- [ ] Assign PHP version (see PHP Version Control)
- [ ] List and manage existing websites
- [ ] FrankenPHP configuration management for each site
- [ ] Redis cache configuration per site

### 2. PHP Version Control
- [ ] Display only currently supported PHP versions (e.g., 8.1, 8.2, 8.3)
- [ ] Allow per-site PHP version selection
- [ ] Backend logic to install/update PHP versions on the server
- [ ] UI to trigger PHP version updates for security
- [ ] Validation to prevent unsupported versions
- [ ] FrankenPHP integration with different PHP versions

### 3. DNS Management
- [ ] Livewire component for managing DNS records (A, CNAME, MX, TXT, etc.)
- [ ] Assign and update domains for each website
- [ ] Integration with DNS provider APIs (or local DNS management)
- [ ] Status feedback for DNS propagation

### 4. GitHub Integration & Automated Deployment
- [ ] OAuth or PAT-based GitHub authentication
- [ ] UI to select repository and production branch for each website
- [ ] Webhook listener for branch updates
- [ ] Automated deployment pipeline:
    - [ ] Pull latest code
    - [ ] Run composer install
    - [ ] Run npm/yarn build (Tailwind, JS, etc.)
    - [ ] Run database migrations (if needed)
    - [ ] Clear Redis caches
    - [ ] Restart FrankenPHP processes
- [ ] Deployment status and logs UI

### 5. Server Metrics Monitoring
- [ ] Collect and display metrics: CPU, RAM, disk, network, FrankenPHP status, Redis performance, etc.
- [ ] Livewire dashboard for real-time updates
- [ ] Alerts for resource thresholds

### 6. Security & Access Control
- [ ] Laravel authentication (with optional 2FA)
- [ ] Role-based access (admin, operator, viewer)
- [ ] Audit logs for critical actions

### 7. Testing & Code Quality
- [ ] PestPHP for unit, feature, and integration tests
- [ ] PHPStan for static analysis (level max)
- [ ] GitHub Actions for CI/CD (run tests, PHPStan, and deployment)

---

## Task Breakdown

### Website Management
- [ ] Design Livewire components for website CRUD
- [ ] Implement Eloquent models and migrations
- [ ] Validation and error handling
- [ ] FrankenPHP configuration templates
- [ ] Redis cache configuration management

### PHP Version Control
- [ ] Service to detect and list supported PHP versions
- [ ] Scripts to install/update PHP versions
- [ ] UI for version selection and update
- [ ] FrankenPHP integration with multiple PHP versions

### DNS Management
- [ ] Integrate with DNS provider APIs (Cloudflare, Route53, etc.)
- [ ] UI for DNS record CRUD
- [ ] Feedback for DNS status

### GitHub Integration & Deployment
- [ ] GitHub OAuth/PAT setup
- [ ] Webhook endpoint for deployments
- [ ] Deployment scripts (composer, npm, artisan, etc.)
- [ ] UI for deployment status/logs
- [ ] FrankenPHP process management during deployments
- [ ] Redis cache clearing and warm-up strategies

### Server Metrics Monitoring
- [ ] Collect metrics using system tools (e.g., Laravel Octane, sysinfo packages)
- [ ] FrankenPHP performance monitoring
- [ ] Redis performance and memory usage monitoring
- [ ] Livewire dashboard for metrics
- [ ] Alerting system

### Testing & Code Quality
- [ ] Write PestPHP tests for all features
- [ ] Configure PHPStan (level max)
- [ ] Set up CI pipeline

---

## Technologies Used
- **Backend:** Laravel 12, PHP 8.4+
- **Frontend:** Livewire 3.5+, Blade, Tailwind CSS, daisyUI, Alpine.js
- **Web Server:** FrankenPHP (Go-based web server with embedded PHP)
- **Caching:** Redis (sessions, cache, queues)
- **Database:** MySQL/PostgreSQL/SQLite
- **Process Management:** Supervisor
- **Testing:** PestPHP, PHPStan
- **CI/CD:** GitHub Actions
- **Other:** Composer, NPM/Yarn

---

## Infrastructure Architecture

### FrankenPHP Benefits
- **Performance:** Direct PHP embedding eliminates the overhead of FastCGI communication
- **Simplicity:** Single binary deployment reduces complexity compared to Nginx + PHP-FPM
- **Modern:** Built with Go, offering excellent concurrency and performance
- **Laravel Compatible:** Full compatibility with Laravel applications
- **Easy Configuration:** Simple configuration files for each site

### Redis Integration
- **Session Storage:** Secure, fast session management
- **Application Caching:** Database query caching, view caching, route caching
- **Queue Management:** Background job processing
- **Real-time Features:** Support for Livewire's real-time capabilities
- **Performance Monitoring:** Track cache hit rates and performance metrics

### Deployment Strategy
- **Per-Site FrankenPHP Instances:** Each website runs in its own FrankenPHP process
- **Redis Namespacing:** Separate cache namespaces for each site
- **Supervisor Management:** Automatic process restart and monitoring
- **Zero-Downtime Deployments:** Rolling updates with health checks

---

## Contribution & Development
- Follow PSR-12 and Laravel best practices
- Use strict typing and SOLID principles
- Modularize code with Livewire and Blade components
- Write and maintain comprehensive tests
- Ensure code passes PHPStan (level max) before merging

---

## License
[MIT](LICENSE)

---

## Local Development with Docker

To ensure a consistent development environment and make it easy to test the application both manually and with automated tests, this project provides a Docker-based setup.

### Getting Started

1. **Install Docker Desktop** (https://www.docker.com/products/docker-desktop/)
2. **Clone the repository**
3. **Create environment file:**
   ```sh
   cp .env.example .env 2>/dev/null || echo "Create .env file manually with database and Redis configuration"
   ```
4. **Start the containers:**
   ```sh
   docker compose up -d --build
   ```
5. **Run migrations:**
   ```sh
   docker compose exec app php artisan migrate
   ```
6. **Access the app:**
   Visit http://localhost:8000

### Database Options

The application supports multiple database options:

- **SQLite (Default):** Automatically configured for development
- **MySQL:** Use `docker compose --profile mysql up -d` to start with MySQL
- **PostgreSQL:** Use `docker compose --profile postgres up -d` to start with PostgreSQL

### Redis

Redis is automatically started and configured for:
- Session storage
- Application caching
- Queue management
- Real-time features

### Running Tests

- **PestPHP tests:**
  ```sh
  docker compose exec app ./vendor/bin/pest
  ```
- **PHPStan static analysis:**
  ```sh
  docker compose exec app ./vendor/bin/phpstan analyse
  ``` 