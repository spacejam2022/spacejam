#!/bin/bash

echo "This will cause some downtime, are you sure you want to continue? Press enter to continue or CTRL+C to cancel"
read ACCEPT

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

mkdir -p /cs/data/finger/home /cs/data/finger/etc
touch /cs/data/finger/etc/passwd /cs/data/finger/etc/group /cs/data/finger/etc/shadow
chown -R cn:cn /cs/data/finger

docker build -t finger ${BASE}/finger
docker stack rm finger || true
while docker network inspect finger_default >/dev/null 2>&1 ; do sleep 1; done
docker stack deploy --compose-file ${BASE}/docker-compose.yml finger
${BASE}/wait-for-it.sh localhost:79 -t 120
