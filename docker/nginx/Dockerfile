FROM nginx

ADD nginx.conf /etc/nginx/
ADD francken.conf /etc/nginx/conf.d/francken.conf

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN rm /etc/nginx/conf.d/default.conf
