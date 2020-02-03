#!/bin/bash


if pg-wait $AP_DB_URL 5432; then

    export PGPASSWORD=$AP_DB_PASS
    if psql -h $AP_DB_URL -p 5432 -U $AP_DB_USER -lqt | cut -d \| -f 1 | grep -qw $AP_DB_NAME; then
        echo "database exists"

    else
        psql -h $AP_DB_URL -p 5432 -U $AP_DB_USER -c "create database $AP_DB_NAME" && sleep 5
        cd  $APP && \
        php yii migrate && \
        php yii migrate --migrationPath=@bedezign/yii2/audit/migrations

    fi
    export HOST_IP = $(hostname -i | tr -d " " | sed 's/[0-9]*$/1/')

    if [ ! -f /env ]; then
        printenv | grep "AP_" >> /etc/environment

        for file in /exec/*
        do
            /bin/bash "$file" >> /tmp/results.out
        done

        touch /env
    fi

    source /etc/apache2/envvars
    exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

else
    echo "Postgres is unavailable"
    exit 1
fi
