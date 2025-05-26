# LAMP Webapp: Judge Scoring System

A LAMP (Linux, Apache, MySQL, PHP) stack application for managing judges, scoring participants, and displaying a live scoreboard.

## Environment setup
rename the config.example.php to config.php and replace with your variables

## Database Setup
1. Import the schema using MySQL:
   mysql -u root -p lamp_db < sql/schema.sql

## Set Permissions 
sudo chown -R www-data:www-data /var/www/html/lamp-webapp
sudo chmod -R 755 /var/www/html/lamp-webapp

## Assumptions
No Authentication: Judges/admins are assumed to be pre-authorized (login not implemented).
Pre-registered Users: Users are manually added to the database for demo purposes.
Single Judge Scoring: A judge can score the same user multiple times (no uniqueness constraints).

## Design Choices
``Backend``
PDO over mysqli:
    Used PDO for prepared statements to prevent SQL injection.
    Implemented a singleton DB connection class for reusability.
MVC-like Structure:
    Separated concerns into admin/, judge/, and public/ directories.
    Centralized configuration in includes/.
Security:
    Sanitized inputs with htmlspecialchars() and filter_input().
    Moved sensitive credentials to config.php outside the web root.
``Frontend``
Vanilla JavaScript:
    Used fetch() for scoreboard auto-refresh instead of jQuery/React to minimize dependencies.
CSS Best Practices:
    Modular stylesheets (admin.css, judge.css, scoreboard.css).
    Responsive design with Flexbox.
User Feedback:
    Success/error messages via URL parameters.
    Loading states for API calls.

## Future Features
User Authentication:
    Implement judge/admin login with PHP sessions.
    Password hashing via password_hash().
Real-Time Updates:
    Replace polling with WebSockets/Pusher.
Enhanced Security:
    Rate limiting for API endpoints.
    CSRF protection.
Additional Features:
    Export scores to CSV/PDF.
    Judge scoring history.
    User profile avatars.
Deployment Improvements:
    Dockerize the application.
    Implement CI/CD pipelines.

## Security Notes
- **XSS Prevention**: All inputs/outputs are sanitized with `htmlspecialchars()`.  
- **SQL Injection Protection**: PDO prepared statements are used for all database interactions.  
- **Duplicate Check**: Usernames are validated for uniqueness before insertion.
- **IDOR Protection**: Consider replacing IDs with UUIDs or CUIDs to prevent Indirect Object Reference 
eg user/1 to user/avvdwyu7300-d3bd3ih 