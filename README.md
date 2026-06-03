# FitZone Fitness Center Portal 🏋️‍♂️💪

[![Website Live](https://img.shields.io/badge/Live-Demo-brightgreen?style=for-the-badge&logo=render&logoColor=white)](https://fitzone-0sp0.onrender.com/index.html)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**Live Deployed URL:** [https://fitzone-0sp0.onrender.com/index.html](https://fitzone-0sp0.onrender.com/index.html)

FitZone is a production-grade, responsive, and visually stunning web application built to streamline operations for the **FitZone Fitness Center** in Kurunegala, Sri Lanka. 

The application is styled with a **premium dark glassmorphism theme** (electric gym orange and cyan accents) and features a secure, SQL-injection-resistant PHP backend with session-based authentication.

---

## 🚀 Key Features

### 🌟 Customer Experience
* **Gym Overview & Services:** Highly polished landing page, contact forms, classes grid, and custom membership plans.
* **1-on-1 Personal Training:** Interactive personal coaching cards detailing certified trainers, specialties, and training packages.
* **Interactive Wellness Blog:** Informative articles offering workout routines (3-Day Push/Pull/Legs), healthy recipes, meal plans, and member success stories.
* **Personalized Dashboard:**
  * View active membership plan details.
  * Book training sessions (automatically mapped to the customer profile).
  * Submit queries regarding events, classes, or general inquiries.
  * Monitor real-time appointment lists and responses from gym staff.

### 🛡️ Staff & Administrator Experience
* **Metric Overview Dashboard:** Modern KPI cards detailing total gym members, booked sessions, and active pending queries.
* **Appointment Tracking:** List of booked appointments joined with client names and emails (no anonymous entries).
* **Interactive Response Panel:** Thread-based query responding system allowing staff to resolve user questions directly from the dashboard.
* **Role-Based Portals:** Restrictive access levels separating standard customers, gym staff members, and administrators.

---

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3 (Vanilla Custom Layouts & Glassmorphism), JavaScript (Micro-animations).
* **Backend:** PHP 8.x (Secure Session Authentication & Parameterized SQL Queries).
* **Database:** MySQL 8.0.
* **DevOps & Containers:** Docker, Docker-Compose (Apache + PHP extension compilation).

---

## 💻 Local Installation & Setup

Ensure you have **Docker Desktop** installed and running on your system.

### 1. Launch the Application (Docker)
Run the following command from the root of the project directory to build the PHP image (with `mysqli` extensions compiled) and spin up the database:

```cmd
docker-compose up -d --build
```

### 2. Access the Portal
* **Main Website:** Open your browser and navigate to **[http://localhost:8000](http://localhost:8000)** (or `http://localhost:8000/index.html`).
* **Database Access:** The MySQL database is exposed on host port `3309` (User: `root`, Password: `""` (empty), Database: `fitzone`).

### 3. Stop the Servers
```cmd
docker-compose down
```

---

## 🔑 Seeded Demo Accounts

To test the system immediately, you can log in using these pre-seeded accounts:

### 👤 Customer Login
Go to [http://localhost:8000/customer-signup-login.php](http://localhost:8000/customer-signup-login.php):
* **Email:** `Madkuruppu99@gmail.com`
* **Password:** `12345`

### 🧑‍💼 Gym Staff Login
Go to [http://localhost:8000/staff-admin-login.php](http://localhost:8000/staff-admin-login.php):
* **Username:** `dinuka`
* **Password:** `1111`
* **Role:** Gym Staff Member

### 👑 Administrator Login
Go to [http://localhost:8000/staff-admin-login.php](http://localhost:8000/staff-admin-login.php):
* **Username:** `lasith`
* **Password:** `1111`
* **Role:** Administrator

---

## 🌐 Production Deployment (Render + Clever Cloud)

The code connects to database credentials via environment variables with local fallbacks inside [connect.php](connect.php).

### 1. Database Hosting (Clever Cloud)
1. Register a free account at [Clever Cloud](https://www.clever-cloud.com/).
2. Create a free **MySQL Add-on** (Shared plan).
3. Open the **phpMyAdmin** dashboard and import the [fitzone.sql](fitzone.sql) file.
4. Copy the host, database name, user, password, and port credentials.

### 2. Web Hosting (Render)
1. Sign up at [Render](https://render.com/) and connect your GitHub repository.
2. Create a new **Web Service** with runtime set to **PHP**.
3. Under **Advanced**, add the environment variables matching the credentials from Clever Cloud:
   * `DB_HOST`
   * `DB_USER`
   * `DB_PASSWORD`
   * `DB_NAME`
   * `DB_PORT`
4. Click **Create Web Service** to deploy.
