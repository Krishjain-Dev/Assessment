# User Management System

## Overview
This is a full-stack user management system built with:
- **Frontend**: React (with Tailwind CSS)
- **Backend**: PHP (REST API)
- **Database**: MySQL

The application allows users to be **viewed, added, updated, and deleted** using a React-based UI and a PHP backend.

---

## Project Structure
/GOQII assessment
│── /BackendApi       (PHP API files: api.php, config.php)
│── /ReactApp         (React frontend application)
│── database.sql      (Database schema for MySQL)
│── README.md         (Project documentation)


**Backend Setup (PHP & MySQL)**
1. Install XAMPP (or any local server with PHP & MySQL).
2. Move the /BackendApi folder inside the server's htdocs directory.
3. Create a MySQL database and import database.sql:
   Open phpMyAdmin.
   Create a new database: assessment.
   Import database.sql into assessment.
5. Update database credentials in /BackendApi/config.php (set correct DB name, user, and password).

**Frontend Setup (React)**
1. Navigate to the ReactApp folder:
   cd ReactApp
2. Install dependencies:
   npm install
3. Start the React development server:
   npm start

**API Endpoints**
  Method	Endpoint	Description
  GET	    /api.php	Get all users
  POST	  /api.php	Add a new user
  PUT	    /api.php	Update user details
  DELETE	/api.php	Delete a user

**Features**   
1. Users have name, email, password, and date of birth.
2. Passwords are hashed for security.
3. The API follows RESTful principles.
4. The React frontend makes API calls to manage users.
5. CORS enabled to allow frontend-backend communication.

**Version Control (Git)**
This project follows Git best practices, including:
  Branches:
    main → Stable version
    feature-user-management → Development work
  Commits: Regular, meaningful commit messages
  Pull Requests: Feature branches merged via PRs

**Contributors**
Krish Jain - [GitHub Profile](https://github.com/Krishjain-Dev)
