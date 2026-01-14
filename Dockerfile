# PHP এবং Apache সহ অফিশিয়াল ইমেজ ব্যবহার করছি
FROM php:8.2-apache

# আপনার সব ফাইল কন্টেইনারের ভেতরে কপি করা হচ্ছে
COPY . /var/www/html/

# Apache এর জন্য পারমিশন ঠিক করা
RUN chown -R www-data:www-data /var/www/html/

# পোর্ট ৮০ এক্সপোজ করা
EXPOSE 80
