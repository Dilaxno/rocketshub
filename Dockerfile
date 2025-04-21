FROM php:8.1-apache-bullseye

# Install dependencies and clean up in a single layer to reduce image size
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers

# Security configurations for Apache
RUN echo 'ServerTokens Prod' >> /etc/apache2/apache2.conf && \
    echo 'ServerSignature Off' >> /etc/apache2/apache2.conf && \
    echo 'TraceEnable Off' >> /etc/apache2/apache2.conf && \
    echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Create a non-root user for running Apache
RUN groupadd -g 1000 appuser && \
    useradd -u 1000 -g appuser -m -s /bin/bash appuser

# Copy application files
COPY --chown=www-data:www-data . /var/www/html/

# Set proper permissions
RUN find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Remove any potentially sensitive files
RUN rm -rf /var/www/html/.git* /var/www/html/.env* /var/www/html/README.md

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]