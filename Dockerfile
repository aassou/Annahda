FROM php:7.1.2-apache 
RUN docker-php-ext-install mysqli  pdo_mysql pdo
COPY db/annahda.sql /docker-entrypoint-initdb.d/