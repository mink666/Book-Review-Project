# Book Review App

A Laravel web application for Browse and reviewing books and authors. Includes user authentication, CRUD operations for books & authors (with cover images), filtering/search, and a basic review system.

Developed by: **Minh Nguyen Anh**
Project for: **Aptech PHP Course**

## Setup Instructions

Please follow these steps carefully to set up the project locally:

1.  **Clone Repository:**
    ```bash
    git clone [https://github.com/](https://github.com/)[YourUsername]/[Your-Repo-Name].git
    cd [Your-Repo-Name]
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    npm run dev
    ```
    *(Use `npm run build` for production simulation)*

3.  **Environment Setup:**
    * Copy the example environment file:
      ```bash
      cp .env.example .env
      ```
    * Generate the application key:
      ```bash
      php artisan key:generate
      ```
    * **Configure `.env`:** Open the `.env` file and set your database connection details (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Ensure `APP_URL` is correct (usually `http://127.0.0.1:8000` for local testing).

4.  **Database Migration:**
    * Make sure you have created the database specified in your `.env` file.
    * Run the migrations:
      ```bash
      php artisan migrate
      ```

5.  **Storage Link:** Create the symbolic link for public file storage (required for cover images):
    ```bash
    php artisan storage:link
    ```

6.  **Serve the Application:**
    ```bash
    php artisan serve
    ```

7.  **Access:** Visit the URL provided (usually `http://127.0.0.1:8000`) in your web browser. You can register a new user or log in if test users were seeded.

## Features Overview

* **User Authentication:** Register, Login, Logout functionality (built from scratch).
* **Book Management:** Full CRUD operations with cover image uploads.
* **Author Management:** Full CRUD operations with a dynamic "Add Author" modal on the book form (using Alpine.js).
* **Browse & Discovery:**
    * Paginated Book index with search (title/author) and filtering (latest, popular, highest-rated).
    * Paginated Author index with search.
    * Detail pages for both Books and Authors.
* **Review System (Bonus Feature):**
    * Logged-in users can add ratings & optional text reviews to books.
    * Reviews are displayed on the book detail page.
    * Users can delete their *own* reviews. (Edit functionality not implemented).
* **Core Relationships:** Many-to-Many (Books-Authors), One-to-Many (Books-Reviews, Users-Reviews).

## Technologies Used

* Laravel
* Blade
* MySQL (or specify if different)
* Tailwind CSS
* Alpine.js

## Known Issues / Limitations

* Editing existing reviews is not implemented.
