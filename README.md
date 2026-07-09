# Pizza Order Webapp

A full-stack pizza ordering application built in PHP with a custom MVC
structure, MariaDB, and Docker. Customers browse a menu and place an order,
bakers work through a kitchen queue, and drivers handle delivery — each
behind role-based authentication.

## Features

- **Menu & cart** — client-side cart (`assets/js/script.js`) with a
  server-rendered menu and PRG-based checkout flow.
- **Order status tracking** — customers can check their order's status via
  a small JSON API (`assets/js/customer.js` + `ApiController`).
- **Role-based authentication** — registration/login for three roles
  (`customer`, `baker`, `driver`), passwords hashed with `password_hash()`,
  and a `requireRole()` guard on `BaseController` that restricts each
  dashboard to the matching role.
- **SQL-injection-safe queries** — all database access goes through MySQLi
  prepared statements.

## Architecture

Custom lightweight MVC, no framework:

```
src/Praktikum/
├── index.php                  # front controller / router entry point
└── App/
    ├── Core/                  # Router, BaseController, BaseModel
    ├── Controller/             # one controller per route
    ├── Model/                  # OrderModel, UserModel
    └── View/                   # .view.php templates + partials
```

- **Routing**: `.htaccess` rewrites `/<route>` to `index.php?url=<route>`;
  `index.php` maps the route to a controller class.
- **Controllers**: each implements `processData()` (handle POST/mutations),
  `generateResponse()` (render the view), and `handleRequest()` (orchestrates
  both). Role-restricted controllers call `$this->requireRole(...)` first.
- **Database**: MariaDB via MySQLi, schema and seed data in
  `mariadb/mariadb.setup/*.sql`, auto-loaded on container init.

### Docker services (`docker-compose.yml`)

| Service      | Purpose                                   |
|--------------|--------------------------------------------|
| `php-apache` | Apache + PHP, serves the app from `src/`   |
| `mariadb`    | Database server (`pizzaservice` schema)    |
| `phpmyadmin` | Web UI for the database (localhost:8085)   |

## Setup

1. Install [Docker](https://www.docker.com).
2. `docker-compose up -d`
3. Visit `http://localhost/Praktikum/index.php` (menu/order page).
4. Register a customer account at `?url=register`, or log in as one of the
   seeded staff accounts (see `mariadb/mariadb.setup/03-Users.sql` for the
   dev-only seed credentials).

## Development Process

This is a university project built for the EWA (web application
development) lab at Hochschule Darmstadt. The base structure — the MVC
skeleton, Docker setup, and initial ordering flow — came out of paired
coursework with a lab partner. The authentication system (and further
features built on top of it) was designed, implemented, and tested by me
independently afterward as a personal extension of the project.
