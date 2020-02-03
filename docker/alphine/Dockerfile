# PHP Docker image for Yii 2.0 Framework runtime
# ==============================================

FROM hardtyz/alphine-fpm-php7.1

ARG env=Production

ADD docker/alphine/pg-wait /usr/bin/pg-wait
ADD docker/alphine/entrypoint.sh /entrypoint.sh
ADD ./build/ /

ADD --chown=www-data:www-data . /app
RUN chmod +x /entrypoint.sh && \
    chmod +x /usr/bin/pg-wait && \
    cd /app && \
    composer global require hirak/prestissimo && \
    if [ "$env" = "Development" ] ; then composer install   ; else composer install --no-dev  ; fi && \
    composer clear-cache  && \
    php init --env=$env --overwrite=All && \
    ln -s /app/api/web /app/backend/web/api  && \
    php requirements.php

WORKDIR /app/api
ENTRYPOINT ["/entrypoint.sh"]


