
## Database Setup
1. Import the schema using MySQL:
   ```bash
   mysql -u root -p lamp_db < sql/schema.sql


## Admin Panel Features
- **Add Judges**: Form with validation (unique usernames).  
- **View Judges**: Table displaying all judges.  
- **Styling**: Clean, responsive design with `admin.css`.

## Security Notes
- **XSS Prevention**: All inputs/outputs are sanitized with `htmlspecialchars()`.  
- **SQL Injection Protection**: PDO prepared statements are used for all database interactions.  
- **Duplicate Check**: Usernames are validated for uniqueness before insertion.

