server {
  listen 80 default_server;
  listen [::]:80 default_server;

  listen 443 ssl default_server;
  listen [::]:443 ssl default_server;
  ssl_certificate /etc/nginx/sites-available/nginx-selfsigned.crt;
  ssl_certificate_key /etc/nginx/sites-available/nginx-selfsigned.key;

  # root /var/www/html;
  root /home/nashady/Documents/Dropbox/iskarma.com/everything;

  index index.php index.html index.htm;

  server_name localhost;

  # Deny access to sensitive files
  location ~ /\. {
    deny all;
    access_log off;
    log_not_found off;
  }

  # Prevent access to PHP files in sensitive directories
  location ~ ^/private/.*\.php$ {
    deny all;
  }

  # Disable directory indexing
  location / {
    try_files $uri $uri/ /index.php?$args =404;
    autoindex.off;
  }
  # PHP Configuration
  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
  }

  # Restrict access to private directory
  location ^~ /private/ {
    internal;
    alias /home/nashady/Documents/Dropbox/iskarma.com/everything/private;
  }

  # Security headers
  add_header X-Content-Type-Options nosniff;
  add_header X-Frame-Options "SAMEORIGIN";
  add_header X-XSS-Protection "1; mode=block";

  # Disable Server Tokens
  server_tokens off;

  # Error Pages
  error_page 404 /404.html;
  location = /404.html {
    root /home/nashady/Documents/Dropbox/iskarma.com/everything;
  }

  error_page 500 502 503 504 /50x.html;
  location = /50x.html {
    root /home/nashady/Documents/Dropbox/iskarma.com/everything;
  }
}
