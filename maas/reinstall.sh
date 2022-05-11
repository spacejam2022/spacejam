#!/bin/bash

echo "This will cause some downtime, are you sure you want to continue? Press enter to continue or CTRL+C to cancel"
read ACCEPT

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

docker build -t maas ${BASE}/maas
docker stack rm maas || true
while docker network inspect maas_default >/dev/null 2>&1 ; do sleep 1; done
docker stack deploy --compose-file ${BASE}/docker-compose.yml maas
${BASE}/wait-for-it.sh localhost:1337 -t 90
