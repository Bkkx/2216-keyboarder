# Use the official Nginx image from the Docker Hub
FROM nginx:latest

# Install necessary packages for PHP and mysqli
RUN apt-get update && apt-get install -y \
    php-fpm \
    php-mysqli \
    && rm -rf /var/lib/apt/lists/*

# Copy custom Nginx configuration file
COPY ./default.conf /etc/nginx/conf.d/default.conf

# Copy HTML files to the Nginx web root directory
#COPY ./html /var/www/html

# Expose port 80
EXPOSE 80

# Start PHP-FPM in the background and Nginx in the foreground
#CMD php-fpm && nginx -g 'daemon off;'
