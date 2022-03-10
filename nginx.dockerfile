FROM nginx:stable-alpine

ADD ./nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./nginx/default.conf /etc/nginx/conf.d/default.conf
ADD ./nginx/ssl/spot.kenyahmis.org.crt /etc/nginx/spot.kenyahmis.org.crt
ADD ./nginx/ssl/kenyahmis.org.key /etc/nginx/kenyahmis.org.key

RUN mkdir -p /var/www/html

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN chown laravel:laravel /var/www/html
