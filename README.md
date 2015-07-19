# ci_boilerplate_management
Boilerplate with CodeIgniter (PHP framework), AdminLTE (bootstrap template), MySQL (database) to boost up the project setup of any types of management type web application with Standard User management system done.

### Configuration
1. Open application/config/config.php and set your config["base_url"] as project path.
2. Open application/config/database.php and set hostname, username, password and database.
3. Open phpmyadmin, create a database and import ci_boilerplate_management.sql into that newly created database.
4. If you want to change user's role from default one update roles table and open users_helper.php and update isAdmin() method.

## Execution
1. Open browser and hit your "base_url/"
2. Login with admin/123