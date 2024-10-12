FROM php:8.1-cli

RUN apt-get update && apt-get install -y cron && rm -rf /var/lib/apt/lists/*

RUN echo "*/1 * * * * php /var/www/html/src/postEvent.php >> /var/log/cron.log 2>&1" > /etc/cron.d/my-cron-job

RUN chmod 0644 /etc/cron.d/my-cron-job

RUN crontab /etc/cron.d/my-cron-job

RUN touch /var/log/cron.log

CMD ["cron", "-f"]