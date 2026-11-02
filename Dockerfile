FROM php:8.3-apache

# Enable Apache URL rewriting
RUN a2enmod rewrite

# Copy the project files into the web root
COPY . /var/www/html/

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html

# Apache listens on port 80 inside the container
EXPOSE 80