FROM php:8.1-apache
# -----------------------------
# Linux Layer
# -----------------------------
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libaio1 \
    libicu-dev \
    libxml2-dev \
    libpng-dev \
    g++ \
    unixodbc-dev \
    unzip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# -----------------------------
# Instalação de extensão PHP
# -----------------------------
RUN docker-php-ext-install intl pdo pdo_mysql mysqli soap ctype fileinfo

# Ativa o mod_rewrite para o Apache
RUN a2enmod rewrite

# Define o diretório de trabalho como /var/www/html
WORKDIR /var/www/html

# Modifica a configuração do DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
