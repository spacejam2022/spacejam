FROM registry-1.docker.io/library/ubuntu:18.04

ENV TERM linux

RUN apt-get update && apt-get dist-upgrade -y

RUN apt-get update && apt-get install -y \
    build-essential \
    execstack \
    netcat \
    socat 

COPY Makefile finger.c command.c command.h passwd.c passwd.h util.c util.h /
RUN make

CMD ["/usr/bin/socat", "-s", "tcp4-listen:1079,reuseaddr,fork", "exec:/finger,stderr"]
