# ENV

# Admin Credentials
ADMIN_USERNAME=admin
ADMIN_PASSWORD=Admin@123

# Application Settings
APP_NAME=IbraTech Blog Admin
SESSION_TIMEOUT=3600

# File Paths
BLOG_DATA_PATH=blogData.json
UPLOAD_PATH=uploads/images/



# HTACCESS
# Protect .env file
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Protect JSON file from direct access (optional)
<Files "blogData.json">
    Order allow,deny
    Deny from all
</Files>

# Enable rewrite engine
RewriteEngine On

# Redirect to login if accessing admin without session
# (This is handled by PHP, just for extra security)

# Set max upload file size (adjust as needed)
php_value upload_max_filesize 5M
php_value post_max_size 6M

# Enable error reporting (disable in production)
# php_flag display_errors On

# Set default timezone
php_value date.timezone "Asia/Jakarta"