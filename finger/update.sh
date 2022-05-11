#!/bin/bash

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

docker build -t finger ${BASE}/finger
docker service update --force --update-order start-first finger_finger
