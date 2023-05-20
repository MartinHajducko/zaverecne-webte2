# Use an official PHP runtime as the base image
FROM php:latest

# Set the working directory inside the container
WORKDIR /var/www/site230.webte.fei.stuba.sk/zadanie5

# Copy the application files to the container
COPY . .

# Install any necessary dependencies
# For example, if you are using Composer to manage dependencies, you can uncomment the following lines:
# COPY composer.json composer.lock ./
# RUN composer install --no-scripts --no-autoloader

# Expose the port where your application will run
EXPOSE 80

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:8080"]
