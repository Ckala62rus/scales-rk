# Первое включение


#### Debugg PHPStorm
* https://www.youtube.com/watch?v=9MhHQJjMulk


#### Cron
* https://laracasts.com/discuss/channels/code-review/crontab-no-scheduled-commands-are-ready-to-run
В случае ошибки крона, что нет запланированных заданий. 
Нужно почистить кэш или удалить.
всё из директории storage/framework/cache/data


#### Supervisor (Rebuild supervisor)
* docker-compose up -d --no-deps --build supervisor
