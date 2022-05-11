FROM registry-1.docker.io/library/ubuntu:18.04

ENV TERM linux

RUN apt-get update && apt-get dist-upgrade -y

# add the manpages back
RUN mv /etc/dpkg/dpkg.cfg.d/excludes /etc/dpkg/dpkg.cfg.d/excludes.dpkg-tmp
RUN apt-get update && dpkg -S /usr/share/man/ |sed 's|, |\n|g;s|: [^:]*$||' | DEBIAN_FRONTEND=noninteractive xargs apt-get install --reinstall -y

RUN apt-get update && apt-get install -y \
    man-db \
    manpages \
    netcat \
    socat 

COPY maas /bin/maas

CMD ["/usr/bin/socat", "tcp4-listen:1337,reuseaddr,fork", "exec:/bin/maas,stderr,pty"]
