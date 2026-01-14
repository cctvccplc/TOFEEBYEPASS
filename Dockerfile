FROM php:8.2-apache

# আপনার সব ফাইল কপি করা হচ্ছে
COPY . /var/www/html/

# Apache কে বলা হচ্ছে api ফোল্ডারটি ব্যবহার করতে
ENV APACHE_DOCUMENT_ROOT /var/www/html/api
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN chown -R www-data:www-data /var/www/html/
EXPOSE 80
