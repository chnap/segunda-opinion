# Oncological Second Opinion Platform

Web platform for managing oncological second opinion requests.

## Project Status

In development

## Technologies

- PHP
- JavaScript
- HTML / CSS
- MySQL
- PHPMailer
- DriCloud API

## How to start it for now
```bash
sudo /opt/lampp/xampp restart

```

# Links:

[FRONTEND](http://localhost/onco-opinion/)

[BACKEND](http://localhost/onco-opinion/backend.php), it will redirect you to a login.

## Structure

* `index.php` — Public landing page


* `login.php` — Private area access


* `backend.php` — Private panel / management


* `api.php` — Application endpoints


* `DriCloudAdapter.php` — DriCloud integration


* `SmsProvider.php` — SMS service


* `conexion_db.php` — Database connection


* `cambiar_pass.php` — Password change


* `main.js` — Application JavaScript


* `styles.css` — Styles


* `PHPMailer/` — Mail library


* `img/` — Images



## Integrations

* DriCloud


* Email service


* SMS service



## Database

The project uses MySQL.

The included SQL files correspond to the project's schema/database.

## Security

⚠️ Do not store in Git:

* Passwords


* API keys


* Tokens


* Database credentials


* Real patient data


* Clinical documentation


* Logs with sensitive information



## Development

The project is currently under development.

Before making major changes:

```bash
git status
git add .
git commit -m "Description of the change"

```
