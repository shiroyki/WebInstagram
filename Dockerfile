FROM php:apache
RUN DEBIAN_FRONTEND=noninteractive





WORKDIR /var/www/html
COPY web .

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql 

RUN apt-get install -y libmagickwand-dev 
RUN pecl install imagick 
RUN docker-php-ext-enable imagick

RUN mkdir -p /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 755 /var/www/html/uploads



ENV PORT=8000
EXPOSE ${PORT}

RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf
