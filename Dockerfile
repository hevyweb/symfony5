FROM bitnami/php-fpm:latest
RUN apt update
RUN apt -y install ffmpeg