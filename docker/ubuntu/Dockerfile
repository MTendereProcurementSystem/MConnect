FROM git.bts.md:8888/free/images/ubuntu:7.1

ARG env=Production

ADD docker/init.sh /init.sh
ADD --chown=www-data:www-data . $APP
RUN chmod +x /init.sh && \
    cd $APP && \
    composer global require hirak/prestissimo && \
    if [ "$env" = "Development" ] ; then composer install   ; else composer install --no-dev  ; fi && \
    composer clear-cache  && \
    php init --env=$env --overwrite=All && \
    php requirements.php

