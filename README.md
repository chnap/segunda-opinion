# Oncological Second Opinion Platform



Web platform designed for managing oncological second opinion requests for Dr. Juan De la Haba Rodríguez’s clinical practice. The system allows patients to submit their cases in a structured manner and provides the specialist with a control panel for triage and tracking.

## Project Status



In development.

## Technologies



* PHP


* JavaScript


* HTML / CSS


* MySQL


* PHPMailer


* DriCloud API


* GSAP animations


* PDO database connections



## How to Start It for Now



* First, introduce the files in a folder within `/opt/lampp/htdocs`.


* Restart XAMPP using the terminal:



```bash
sudo /opt/lampp/xampp restart

```

## Links



* [FRONTEND](http://localhost/onco-opinion/)

* [BACKEND](http://localhost/onco-opinion/backend.php), which will redirect you to a login.



## Structure



* `index.php` — Public landing page featuring an editorial design, specialized typography, smooth GSAP animations, and an interactive patient admission form.


* `login.php` — Private area access and session-based PHP authentication screen for administrators.


* `backend.php` — Private panel and management interface to view, filter by priority or status, and handle clinical records.


* `api.php` — Application endpoints and centralized controller managing system actions, request processing, demo resets, and automated email notifications.


* `DriCloudAdapter.php` — Structured preliminary adapter for DriCloud API integration.


* `SmsProvider.php` — SMS service provider module.


* `conexion_db.php` — Database connection module using PDO.


* `cambiar_pass.php` — Utility script for generating secure hashes and configuring administrator users (`backend_users`).


* `main.js` — Client-side script handling panel interactivity, filters, modals, and documentation verification checklists.


* `styles.css` — Styles sheet for the application.


* `PHPMailer/` — Mail library directory utilized for sending HTML templates compatible with light and dark mode.


* `img/` — Images directory.



## Integrations



* DriCloud


* Email service (via PHPMailer)


* SMS service



## Database



* The project uses MySQL under the `db_oncologia` schema.


* The included SQL files correspond to the project's schema/database.



## Security



⚠️ Do not store in Git:

* Passwords


* API keys


* Tokens


* Database credentials


* Real patient data


* Clinical documentation


* Logs with sensitive information

---
