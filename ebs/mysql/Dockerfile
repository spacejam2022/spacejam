FROM registry-1.docker.io/library/mysql:latest

COPY auth.cnf /etc/mysql/conf.d/

COPY database.sql /docker-entrypoint-initdb.d/
