#!/bin/bash

echo "This will cause some downtime, are you sure you want to continue? Press enter to continue or CTRL+C to cancel"
read ACCEPT

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

cp ${BASE}/php/code/*.php ${BASE}/web/code/

docker build -t ebs-web ${BASE}/web
docker build -t ebs-php ${BASE}/php
docker build -t ebs-mysql ${BASE}/mysql
docker stack rm ebs || true
while docker network inspect ebs_default >/dev/null 2>&1 ; do sleep 1; done

sudo rm -rf /cs/data/ebs/mysql
sudo mkdir -p /cs/data/ebs/ebs
sudo chown -R cn:cn /cs/data/ebs
sudo mkdir -p /cs/data/ebs/mysql
docker secret rm mysql-root || true

docker stack deploy --compose-file ${BASE}/docker-compose.yml ebs
${BASE}/wait-for-it.sh localhost:8000 -t 90
