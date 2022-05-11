FROM registry-1.docker.io/library/nginx:latest

ENV TERM linux

RUN apt-get update && apt-get dist-upgrade -y

RUN apt-get update && apt-get install -y \
    curl

COPY site.conf /etc/nginx/conf.d/default.conf

COPY code /code
