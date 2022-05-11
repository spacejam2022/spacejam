#!/bin/bash

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

cp ${BASE}/php/code/*.php ${BASE}/web/code/

docker build -t ebs-web ${BASE}/web
docker build -t ebs-php ${BASE}/php
docker service update --force --update-order start-first ebs_web
docker service update --force --update-order start-first ebs_php
