# Book Review App (E-Library)

A web application built with Laravel for Browse books and authors, reading, and writing reviews. Users can register, log in, manage books (including cover images) and authors, filter and search books, and interact with reviews.

Developed by: **Minh Nguyen Anh**
Project for: **[Aptech PHP Course]**

## Features Implemented

* **Authentication:**
    * User Registration (Name, Email, Password)
    * User Login
    * User Logout
    * Guest/Auth access control for relevant pages/actions
* **Books:**
    * List all books (Index page) with pagination
    * View book details (Show page)
    * Create new books
    * Edit existing books
    * Delete books
    * Book Cover Image Uploads (Create/Edit) & Display
    * Search books by Title or Author(s) name
    * Filter books (Latest, Popular Last Month/6 Months, Highest Rated Last Month/6 Months)
    * Display average star rating and review count
* **Authors:**
    * List all authors (Index page) with pagination and book count
    * View author details (Show page) including their books
    * Create new authors
    * Edit existing authors
    * Delete authors
    * Search authors by name
    * Dynamic "Add New Author" modal on Book Create/Edit forms (using Alpine.js + Fetch)
* **Relationships:**
    * Books <=> Authors (Many-to-Many)
    * Books <=> Reviews (One-to-Many)
    * Users <=> Reviews (One-to-Many)
* **Reviews (Bonus Feature):**
    * Display reviews list on Book Detail page (ordered latest first, shows user name, rating stars, text, date).
    * Add new review (rating + optional text) via form on Book Detail page (requires login).
    * Delete own reviews (requires login, includes confirmation).
    * **(Not Implemented):** Editing existing reviews.
* **General:**
    * Homepage with curated lists (Popular, Recent books).
    * Responsive design elements using Tailwind CSS.
    * Reusable forms using Blade partials.
    * Conditional styling for form validation errors.

## Technologies Used

* PHP / Laravel Framework
* MySQL (or your configured database)
* Blade Templating Engine
* Tailwind CSS
* Alpine.js (for Add Author modal)
* Composer
* NPM

## Setup and Installation Instructions

Follow these steps to set up the project locally:

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/](https://github.com/)[YourUsername]/[Your-Repo-Name].git
    cd [Your-Repo-Name]
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies:**
    ```bash
    npm install
    ```

4.  **Compile Frontend Assets:**
    ```bash
    npm run dev
    ```
    *(Use `npm run build` for production)*

5.  **Environment Configuration:**
    * Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    * Generate the application key:
        ```bash
        php artisan key:generate
        ```
    * **Edit the `.env` file:** Configure your database connection details (set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` according to your local setup). Ensure `APP_URL` is correct (e.g., `http://127.0.0.1:8000`).

6.  **Database Migration:**
    * Make sure you have created the database specified in your `.env` file (e.g., `book_review_app`).
    * Run the migrations:
        ```bash
        php artisan migrate
        ```

7.  **Storage Link:** Create the symbolic link for public file storage (needed for cover images):
    ```bash
    php artisan storage:link
    ```


## Usage

1.  **Serve the Application:**
    ```bash
    php artisan serve
    ```
2.  **Access the Site:** Open your web browser and navigate to the URL provided (usually `http://127.0.0.1:8000`).
3.  **Register/Login:** Use the "Sign Up" or "Log In" buttons to create an account or log in.
4.  **Explore:** Browse books and authors, view details, and (if logged in) add reviews or manage books/authors.

## Known Issues / Limitations

* Editing existing reviews is not implemented.

