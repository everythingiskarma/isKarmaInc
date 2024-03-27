#create a new server config file for the domain
sudo nano /etc/nginx/conf.d/iskarma.local.conf

#add a server block to the file
server {
      listen 80;
      listen [::]:80;
      # SSL configuration
      listen 443 ssl;
      listen [::]:443 ssl;
      # include snippets/snakeoil.conf;
      ssl_certificate /home/nashady/data/x10premium/public_html/iskarma.com/ssl/cert.crt;
      ssl_certificate_key /home/nashady/data/x10premium/public_html/iskarma.com/ssl/cert.key;

      root /home/nashady/data/x10premium/public_html;
      index index.php index.html index.htm;

      server_name iskarma.local;

      location / {
              try_files $uri $uri/ =404;
      }

      location ~ \.php$ {
              include snippets/fastcgi-php.conf;
              fastcgi_pass unix:/run/php/php8.2-fpm.sock;
      }

      location ~ /\.ht {
              deny all;
      }
}

# update /etc/hosts file and add
127.0.0.1   iskarma.local
