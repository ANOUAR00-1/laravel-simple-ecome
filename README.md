# Laravel E-commerce School Project

## 📚 Project Description

This is a simple e-commerce management system built with Laravel for a school assignment. It demonstrates the fundamental concepts of the Laravel MVC framework including:

- Models and database relationships
- Controllers for business logic
- Routes for URL mapping
- Migrations for database structure
- Validation for data integrity

## 🎯 Entities

### 1. Client (Customer)

- **Fields**: nom (name), prenom (first name), email, telephone (phone), adresse (address)
- **Relationships**: A client can have many orders (commandes)

### 2. Produit (Product)

- **Fields**: designation (name), prix (price), stock, description, image
- **Relationships**: A product can belong to many orders
- **Optional**: Can belong to a category

### 3. Commande (Order)

- **Fields**: client_id, date, statut (status), notes
- **Relationships**:
    - Belongs to one client
    - Can have many products (Many-to-Many relationship)
- **Pivot Table**: `commande_produit` stores quantity and price for each product in an order

### 4. Category (Optional)

- **Fields**: nom, description, slug
- **Relationships**: A category can have many products

## 🗂️ Project Structure

```
app/
├── Models/
│   ├── Client.php          # Client model with hasMany commandes
│   ├── Produit.php         # Product model with belongsToMany commandes
│   ├── Commande.php        # Order model with relationships
│   └── Category.php        # Category model
│
└── Http/Controllers/
    ├── ClientController.php    # Handles all client operations (CRUD)
    ├── ProduitController.php   # Handles all product operations (CRUD)
    ├── CommandeController.php  # Handles all order operations (CRUD)
    └── CategoryController.php  # Handles all category operations (CRUD)

database/
├── migrations/
│   ├── create_clients_table.php
│   ├── create_categories_table.php
│   ├── create_produits_table.php
│   ├── create_commandes_table.php
│   └── create_commande_produit_table.php  # Pivot table
│
└── seeders/
    └── DatabaseSeeder.php      # Sample data for testing

routes/
└── web.php                     # All application routes
```

## 🔗 Database Relationships Explained

### One-to-Many: Client → Commande

```php
// In Client model
public function commandes() {
    return $this->hasMany(Commande::class);
}

// In Commande model
public function client() {
    return $this->belongsTo(Client::class);
}
```

### Many-to-Many: Commande ↔ Produit

```php
// In Commande model
public function produits() {
    return $this->belongsToMany(Produit::class)
        ->withPivot('quantite', 'prix');
}

// In Produit model
public function commandes() {
    return $this->belongsToMany(Commande::class)
        ->withPivot('quantite', 'prix');
}
```

## 🚀 Installation & Setup

### 1. Clone or Copy the Project

```bash
cd f:\my_education\About_Laravel\laravel_elzero\laravel-learning
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
# Copy .env.example to .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations

```bash
# Create all tables
php artisan migrate
```

### 6. Seed Sample Data (Optional)

```bash
# Add sample clients, products, and orders
php artisan db:seed
```

### 7. Run the Application

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 📋 Available Routes

| Method    | URL                  | Description             |
| --------- | -------------------- | ----------------------- |
| GET       | `/clients`           | List all clients        |
| GET       | `/clients/create`    | Show create client form |
| POST      | `/clients`           | Store new client        |
| GET       | `/clients/{id}`      | Show client details     |
| GET       | `/clients/{id}/edit` | Show edit form          |
| PUT/PATCH | `/clients/{id}`      | Update client           |
| DELETE    | `/clients/{id}`      | Delete client           |

Same pattern applies for:

- `/produits` - Product management
- `/commandes` - Order management
- `/categories` - Category management

## 💡 Key Laravel Concepts Demonstrated

### 1. MVC Pattern

- **Model**: Represents database tables (Client, Produit, Commande)
- **View**: HTML templates (not included, but referenced in controllers)
- **Controller**: Handles requests and business logic

### 2. Eloquent ORM

- Database interaction without writing SQL
- Relationships: `hasMany`, `belongsTo`, `belongsToMany`
- Mass assignment with `$fillable` array

### 3. Validation

```php
$request->validate([
    'nom' => 'required|string|max:255',
    'email' => 'required|email|unique:clients',
]);
```

### 4. Routing

```php
Route::resource('clients', ClientController::class);
// Automatically creates 7 routes: index, create, store, show, edit, update, destroy
```

### 5. Migrations

- Version control for database structure
- Easy to share and replicate database schema

## 📝 Controller Methods Explained

Each controller has these standard methods:

| Method      | Purpose                           |
| ----------- | --------------------------------- |
| `index()`   | Display list of all records       |
| `create()`  | Show form to create new record    |
| `store()`   | Save new record to database       |
| `show()`    | Display single record details     |
| `edit()`    | Show form to edit existing record |
| `update()`  | Save changes to existing record   |
| `destroy()` | Delete a record                   |

## 🎓 For Your Professor

This project demonstrates understanding of:

✅ **Laravel MVC Architecture**

- Clear separation of concerns
- Controllers handle HTTP requests
- Models represent database entities

✅ **Database Design**

- Proper use of foreign keys
- Many-to-Many relationships with pivot tables
- One-to-Many relationships

✅ **Laravel Features**

- Route model binding
- Eloquent ORM relationships
- Request validation
- Mass assignment protection
- Flash messages for user feedback

✅ **Code Quality**

- Descriptive comments explaining WHY and WHAT
- Follows Laravel naming conventions
- PSR standards compliance

## 🔍 Sample Data

After seeding, you'll have:

- **3 Clients**: Jean Dupont, Marie Martin, Pierre Bernard
- **5 Products**: Computer accessories
- **3 Categories**: Electronics, Accessories, Peripherals
- **3 Orders**: With products attached

## 📖 Further Learning

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)
- [Laravel Routing](https://laravel.com/docs/routing)
- [Form Validation](https://laravel.com/docs/validation)

## 👨‍🎓 Author Notes

This project was created as a school assignment to demonstrate proficiency in:

- PHP and Laravel framework
- Database design and relationships
- MVC architectural pattern
- CRUD operations
- Web development best practices

All code includes detailed comments to explain the logic and reasoning behind each implementation decision.
