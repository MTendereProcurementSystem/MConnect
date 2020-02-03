#!/bin/sh

if pg-wait $AP_DB_URL 5432; then

    export PGPASSWORD=$AP_DB_PASS
    if psql -h $AP_DB_URL -p 5432 -U $AP_DB_USER -lqt | cut -d \| -f 1 | grep -qw $AP_DB_NAME; then
        echo "database exists"

    else
        psql -h $AP_DB_URL -p 5432 -U $AP_DB_USER -c "create database $AP_DB_NAME" && sleep 5
        cd  /app && \
        yes | php yii migrate && \
        yes | php yii migrate --migrationPath=@bedezign/yii2/audit/migrations

    fi
    export HOST_IP=$(hostname -i | tr -d " " | sed 's/[0-9]*$/1/')

    set -e

    # Display PHP error's or not
    if [[ "$ERRORS" != "1" ]] ; then
      sed -i -e "s/error_reporting =.*=/error_reporting = E_ALL/g" /usr/etc/php.ini
      sed -i -e "s/display_errors =.*/display_errors = stdout/g" /usr/etc/php.ini
    fi

    # Disable opcache?
    if [[ -v NO_OPCACHE ]]; then
        sed -i -e "s/zend_extension=opcache.so/;zend_extension=opcache.so/g" /etc/php.d/zend-opcache.ini
    fi

    # Tweak nginx to match the workers to cpu's
    procs=$(cat /proc/cpuinfo | grep processor | wc -l)
    sed -i -e "s/worker_processes 5/worker_processes $procs/" /etc/nginx/nginx.conf

    # Very dirty hack to replace variables in code with ENVIRONMENT values
    if [[ -v TEMPLATE_NGINX_HTML ]] ; then
      for i in $(env)
      do
        variable=$(echo "$i" | cut -d'=' -f1)
        value=$(echo "$i" | cut -d'=' -f2)
        if [[ "$variable" != '%s' ]] ; then
          replace='\$\$_'${variable}'_\$\$'
          find /var/www/html -type f -not -path "/var/www/html/vendor/*" -exec sed -i -e 's#'${replace}'#'${value}'#g' {} \;
        fi
      done
    fi

    if [[ -z "$@" ]]; then
      # Start supervisord and services
      exec /usr/bin/supervisord --nodaemon -c /etc/supervisord.conf
    else
      exec "$@"
    fi

else
    echo "Postgres is unavailable"
    exit 1
fi
