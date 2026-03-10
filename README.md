# LuxeCart E-Commerce Project

This is a complete, custom-built PHP web application for an E-Commerce platform. It does not use any external PHP frameworks (like Laravel or CodeIgniter), meaning every piece of routing, database interaction, session management, and rendering logic is written from scratch.

This `README.md` is an exhaustive study guide detailing **all logic, database structures, features, and file responsibilities** to help you understand exactly how the system works.

---

## 1. Core Architecture (Custom MVC)

The project strictly follows the **Model-View-Controller (MVC)** architectural pattern.

1. **Model (`/models`):** Handles the database connection and encapsulates all SQL query execution logic (`Database.php`).
2. **Controller (`/controllers`):** The brain of the application. It receives input from the URL/forms, processes business logic (like checking passwords or calculating totals), fetches data via the Model, and passes that data to the View.
3. **View (`/views`):** The HTML/CSS structure. It takes variables passed by the Controller and renders the user interface.

### The Front Controller Pattern (`index.php`)
Every single request to the site goes through `index.php`.
- The user visits: `http://localhost/Ecommerce task/customer/wishlist`
- Apache (`.htaccess`) rewrites the URL or the PHP server routes it to `index.php`.
- `index.php` grabs the URL string (e.g., `customer/wishlist`) and runs it through a massive `switch ($page)` statement.
- When it finds a match (`case 'customer/wishlist':`), it instantiates the appropriate Controller (`$controller = new WishlistController();`) and calls the required method (`$controller->index();`).

---

## 2. The Database System (`/models/Database.php`)

All database interactions flow through a single custom wrapper class to ensure security and efficiency.

### Key Logic Concepts:
- **Singleton Pattern:** The `Database` class has a `private function __construct()`. This prevents anyone from creating multiple connections using `new Database()`. Instead, controllers must use `Database::getInstance()`. It checks if a connection already exists; if not, it makes one, otherwise it reuses the existing one.
- **Prepared Statements (SQL Injection Prevention):** The custom `fetchAll()`, `fetch()`, `query()`, and `insert()` methods accept a SQL string and an array of variables. Under the hood, they use `$mysqli->prepare()` and `$stmt->bind_param()`. This ensures user input is treated as text, not runnable SQL code, preventing injection hacks.

### The Full Database Schema (`/database/schema.sql`)
1. **`users`:**
   - **Fields:** `id`, `name`, `email` (UNIQUE), `password` (hashed), `role` (ENUM: admin, seller, customer), `is_active`, `seller_status`.
   - **Logic:** Passwords are never plain text; they use `password_hash()` and `password_verify()`. The `role` determines what sidebars and buttons the user can see.
2. **`categories`:**
   - **Fields:** `id`, `name`, `category_url_name`.
   - **Logic:** Used to group products. Nav links iterate over these to form URLs like `/category/electronics`.
3. **`products`:**
   - **Fields:** `id`, `category_id`, `seller_id`, `name`, `slug` (URL-friendly name), `description`, `price`, `sale_price`, `image`, `stock`, `rating`, `review_count`.
   - **Logic:** Linked to `categories` and `users` (specifically sellers) via Foreign Keys. If `sale_price` is not null, the UI shows a discount. If `stock` is 0, the "Add to Cart" button is disabled. 
4. **`cart` & `wishlist`:**
   - **Fields:** `id`, `user_id`, `product_id`, `quantity` (cart only).
   - **Logic:** Links a specific user to a product. Uses a `UNIQUE KEY (user_id, product_id)` constraint so a user can't have duplicate identical rows; instead, the CartController updates the `quantity` of the existing row. Uses `ON DELETE CASCADE` so if a user or product is deleted, the cart items vanish automatically.

---

## 3. Controller Breakdown (The Brains)

Here is a breakdown of every feature and how its logic works in the Controllers.

### `AuthController.php` (Login & Registration)
- **`registerPost()`:** 
  - Validates inputs (e.g., password length, email format using `filter_var()`).
  - Checks if the email already exists using the `Database` class.
  - Hashes the password using `password_hash($password, PASSWORD_DEFAULT)`.
  - Inserts the user, forcefully saves their credentials into the `$_SESSION` global variable (logging them in immediately), and redirects them to their respective dashboard (`/seller` or `/account`).
- **`loginPost()`:**
  - Fetches the user by email.
  - Verifies the password using `password_verify()`.
  - Populates `$_SESSION['user_role']`. This is the variable checked across the entire app to determine authorization.
  - Redirects based on role (Admin -> `/admin`, Seller -> `/seller`, Customer -> `/account`).
- **`logout()`:** Calls `session_destroy()` which wipes all `$_SESSION` data, effectively logging the user out.

### `CartController.php` (Shopping Cart Logistics)
This controller is unique because it handles **both Guest mode and Logged-in mode**.
- **Guest Logic:** If `!isset($_SESSION['user_id'])`, it uses PHP sessions to store cart data: `$_SESSION['guest_cart'][$productId] = $quantity`.
- **Logged-in Logic:** Connects to the database and interacts with the `cart` table.
- **Stock Validation:** When adding or updating quantities, the controller queries the `products` table (`SELECT stock FROM products`). If `$quantity > $product['stock']`, it throws a Session Error (`"Not enough stock"`) and stops execution.

### `WishlistController.php` (Saved Items)
- **Gatekeeping:** The constructor `__construct()` immediately checks if the user is logged in. If not, it redirects to `/login`. Wishlists do not have a guest mode.
- **`add()` & `remove()`:** Simple database insertions and deletions linking the user to a product. The UI utilizes small hidden HTML forms next to product buttons to submit POST requests instantly.

### `SellerController.php` (Vendor Management)
- **Authorization:** Constructor explicitly checks `if ($_SESSION['user_role'] !== 'seller') { exit; }`.
- **`products()` & `createProduct()`:** Sellers can only manage their *own* products. Every SQL query includes `WHERE seller_id = ?`, passing the logged-in user's ID.
- **Image Upload Logic:** When creating a product (`saveProduct()`), it checks `$_FILES['image']`. It sanitizes the filename, prepends `time()` (a UNIX timestamp) to guarantee a unique name, and uses `move_uploaded_file()` to save it to `/public/images/`.
- **`customerHistory()`:** A complex feature using a `UNION ALL` SQL statement. It queries both the `cart` and `wishlist` tables for products belonging *only* to this seller, formats the data uniformly (assigning a string 'Cart' or 'Wishlist' as `action_type`), and orders them chronologically to show sellers who is interacting with their goods.

### `AdminController.php` (System Oversight)
- **Global Control:** Admins have unrestricted views. They can view, edit, approve, or delete *any* user, seller, or category.
- **`sellerDetail()`:** Pulls comprehensive data for a specific vendor, linking multiple tables: `SELECT * FROM users` joined with all associated products from the `products` table, presented on `$page = 'admin/seller-detail'`.

---

## 4. The View Layout Engine (`/views/layouts/main.php`)

To avoid copying HTML `<head>`, `<nav>`, and `<footer>` into 50 different files, the app uses a Master Layout.

**How it renders:**
1. A Controller runs its logic, sets `$pageTitle` and `$currentPage`, and ends by saying `require BASE_PATH . '/views/layouts/main.php';`
2. `main.php` loads the top half of the HTML and the Navbar.
3. Inside `main.php`, near the middle, it does a switch on `$currentPage`:
   ```php
   if (in_array($current, $validViews)) {
       include BASE_PATH . "/views/{$current}.php";
   }
   ```
4. This drops the specific page content (like the Contact form or the Products grid) right into the middle of the layout.
5. It then renders the Footer.

**Smart Navbar Logic (RBAC - Role Based Access Control):**
The layout uses `$_SESSION['user_role']` heavily to manipulate UI.
- `if (!in_array($_SESSION['user_role'], ['admin', 'seller']))`: If the user is a standard customer or guest, show the main nav links (Home, Products, About). If they are an Admin or Seller, *hide* these links to keep their backend dashboards clean.
- Only show the Cart and Wishlist icons if the user is *not* a seller or admin.

---

## 5. Summary Cheat Sheet for Project Reviews

If asked by an interviewer or reviewer "How does X work?", use these explanations:

- **How do you handle URLs and Routing?**
  "I mapped all incoming requests to a single point, `index.php`. It acts as a Front Controller router, parsing the URL string and instantiating the correct Controller class using a switch statement."

- **How does the Cart work without logging in?**
  "The `CartController` checks session state. If no user ID is found, it falls back to an array stored in the PHP global `$_SESSION['guest_cart']`. When they log in later, this can be migrated to the database."

- **How did you make it secure?**
  "I used `password_hash()` for credentials. For database security against SQL Injection, I created a custom wrapper around `mysqli` that forces the use of Prepared Statements (`bind_param`) for every query so raw user input is never executed as code."

- **How did you prevent Sellers from wiping out the database?**
  "Every controller enforces Role-Based Access Control in its constructor. If a seller tries to access an admin URL, they are immediately redirected. Furthermore, all seller database queries enforce a hardcoded `WHERE seller_id = $_SESSION['user_id']` condition."
