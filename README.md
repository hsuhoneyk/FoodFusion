# FoodFusion

A PHP and MySQL recipe and cooking community website with recipes, community posts, events, and culinary learning resources.

## Contents

- PHP pages and `style.css` — site features and styling.
- `images/` — static project images.
- `database/schema.sql` — schema-only database setup. Database row data was excluded.
- `Uploads/` — empty runtime upload folder; uploaded content from the local site was not copied.

## Run locally

1. Copy this folder into the web root of a local PHP environment such as XAMPP.
2. Create the `foodfusion_db` database and import `database/schema.sql` in MySQL.
3. Set the local database connection in `db.php` for your environment.
4. Make the `Uploads/` folder writable by the local web server, then open `index.php` through the local server.

The repository includes the application source and schema, but not local user accounts, recipe records, messages, or uploaded files.
