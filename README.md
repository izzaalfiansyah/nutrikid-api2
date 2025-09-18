# Nutrikid API

Nutrikid API is a Laravel-based application that provides a backend for the Nutrikid application. This API is used to manage data related to child nutrition, including measurements, suggestions, and user data.

## Installation

To get started with the Nutrikid API, you need to have PHP, Composer, and a database (such as MySQL or PostgreSQL) installed on your system.

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/nutrikid-laravel.git
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Create a copy of the `.env` file:**

    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

## Configuration

1.  **Database:**

    Open the `.env` file and update the database configuration:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nutrikid
    DB_USERNAME=root
    DB_PASSWORD=
    ```

2.  **Run migrations:**

    ```bash
    php artisan migrate
    ```

## Usage

To run the application, you can use the following command:

```bash
php artisan serve
```

This will start a development server at `http://localhost:8000`.

## API Endpoints

The following are the available API endpoints:

*   `POST /login`: User login.
*   `GET /logout`: User logout.
*   `GET /profile`: Get the current user's profile.
*   `POST /profile`: Update the current user's profile.
*   `POST /change-password`: Change the current user's password.
*   `POST /refresh-token`: Refresh the authentication token.
*   `POST /user/{id}/change-password`: Change a user's password.
*   `GET /user`: Get a list of users.
*   `GET /user/{id}`: Get a specific user.
*   `POST /user`: Create a new user.
*   `PUT /user/{id}`: Update a user.
*   `DELETE /user/{id}`: Delete a user.
*   `GET /school`: Get a list of schools.
*   `POST /school`: Create a new school.
*   `PUT /school/{id}`: Update a school.
*   `DELETE /school/{id}`: Delete a school.
*   `GET /student`: Get a list of students.
*   `GET /student/{id}`: Get a specific student.
*   `POST /student`: Create a new student.
*   `PUT /student/{id}`: Update a student.
*   `DELETE /student/{id}`: Delete a student.
*   `GET /measurement`: Get a list of measurements.
*   `GET /measurement/{id}`: Get a specific measurement.
*   `POST /measurement`: Create a new measurement.
*   `PUT /measurement/{id}`: Update a measurement.
*   `DELETE /measurement/{id}`: Delete a measurement.
*   `GET /measurement/{measurementId}/suggestion`: Get a list of suggestions for a measurement.
*   `POST /measurement/{measurementId}/suggestion`: Create a new suggestion for a measurement.
*   `PUT /measurement/{measurementId}/suggestion/{id}`: Update a suggestion for a measurement.
*   `DELETE /measurement/{measurementId}/suggestion/{id}`: Delete a suggestion for a measurement.
*   `GET /measurement-suggestion`: Get a list of measurement suggestions.
*   `POST /measurement-suggestion`: Create a new measurement suggestion.
*   `PUT /measurement-suggestion/{id}`: Update a measurement suggestion.
*   `DELETE /measurement-suggestion/{id}`: Delete a measurement suggestion.
*   `GET /team`: Get a list of team members.
*   `POST /calculate`: Calculate the nutritional status of a child.
*   `GET /default-zscore`: Get the default z-score data.

For more details on the API endpoints, please refer to the source code.

## Testing with Postman

[Postman](https://www.postman.com/) is a popular tool for testing APIs. It allows you to send requests to the API endpoints and view the responses.

To make it easier to test the Nutrikid API, we have provided a Postman collection that includes all the available endpoints. You can import this collection into Postman by following these steps:

1.  Open Postman and click the "Import" button.
2.  Select the `nutrikid-api.postman_collection.json` file from the root of the project.
3.  Once the collection is imported, you can start making requests to the API.

### Authentication

Most of the API endpoints require authentication. To authenticate your requests, you need to obtain an authentication token by sending a `POST` request to the `/login` endpoint with your email and password.

Once you have obtained a token, you can add it to the `auth_token` variable in the Postman collection. This will automatically add the `Authorization` header to all the requests in the collection.