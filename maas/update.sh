#!/bin/bash

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

docker build -t maas ${BASE}/maas
docker service update --force --update-order start-first maas_maas
