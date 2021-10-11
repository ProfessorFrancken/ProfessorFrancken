FROM francken/php-base:v8

ADD php.ini /usr/local/etc/php/
ADD example.pool.conf /etc/php5/fpm/pool.d/

# RUN groupadd -g 33 www-data
# RUN useradd -u 33 -ms /bin/bash -g www-data www-data

# RUN mkdir -p /home/www-data/
# RUN chown www-data:www-data /home/www-data/
# RUN usermod -d /home/www-data/ www-data
# ENV XDG_CONFIG_HOME=/home/www-data/.config

# https://semaphoreci.com/community/tutorials/dockerizing-a-ruby-on-rails-application
# --user
# https://medium.com/redbubble/running-a-docker-container-as-a-non-root-user-7d2e00f8ee15
ARG USER_ID
ARG GROUP_ID

RUN addgroup --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user
USER $USER_ID

CMD ["php-fpm", "-F"]
