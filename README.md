
# Laravel Task Management System

This is a Task Management System built with Laravel 10. It offers a set of APIs to manage tasks and users. The project also incorporates Docker for containerization. This document will guide you on setting up and running the project.

## Prerequisites

1.  Ensure you have Docker installed on your machine (for Docker setup). If not, download and install Docker from the [official website](https://www.docker.com/).
    
2.  PHP, Composer, and Laravel CLI should be available on your system (for native engine setup).
    

## Setup

1.  **Clone the Backend Repository**:

bashCopy code

`git clone https://github.com/taliffsss/task-mngt-api.git
cd task-mngt-api` 

2.  **Frontend Repository**:

For the frontend part of the application, refer to: [Task Management Web](https://github.com/taliffsss/task-mngnt-web.git).

Local Setup using xampp
Noe: Make sure you did setup your Database.
 1. Setup your Database, after setting up
	 2. run migration and seeder

### Running with Docker:

3.1 If you wish to run the application in a Docker container:

bashCopy code

`sh docker.sh [master/main] build` 

-   `master` and `main` are used for the production environment.
-   `build` command is used to build the Docker image.
- Now you should be able to access the application on your local host.

Docker setup usage:
Run `sh docker.sh [branch alias] up`
 - up
 - build
 - down
 - ps
 - exec

Branching:
 - main and master 
	 - prod
 - dev
	 - dev
 - Staging
	 - staging 

3.2 **Scheduler**:

The Laravel scheduler runs inside the Docker container, ensuring tasks are executed as defined in the Laravel app.

### Running with Native Engine:

3.1 **Install Dependencies**:

bashCopy code

`composer install` 

3.2 **Run the Application**:

bashCopy code

`php artisan serve` 

The application will start, and by default, it should be available at `http://localhost:8000`.

## API Routes

### Authentication:

-   **Login**: `POST /api/auth/login`
-   **Signup**: `POST /api/signup`
-   **Logout (requires JWT)**: `POST /api/auth/logout`

### Task Management (requires JWT):
-   **Create a Task**: `POST /api/task/create`
-   **Update a Task**: `PUT /api/task/update/{id}`
-   **Delete a Task**: `DELETE /api/task/delete/{id}`
-   **Show a Task**: `GET /api/task/show/{id}`
-   **List All Tasks**: `GET /api/task/list`

### Task Status (requires JWT):

-   **List Task Statuses**: `GET /api/task-status/list`

A scheduler run daily to delete 30 days old data in task table you may see at Console/Commands