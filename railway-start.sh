#!/bin/bash

# This script is used to start the application on Railway

# Display PHP version
echo "PHP Version: $(php -v | head -n 1)"

# Display Apache version
echo "Apache Version: $(apache2 -v | head -n 1)"

# Start Apache with the Heroku PHP Apache2 buildpack
echo "Starting web server..."
exec heroku-php-apache2