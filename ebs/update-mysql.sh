#!/bin/bash

set -euxo pipefail

BASE=$(readlink -f $(dirname "$(readlink -f $0)"))

cp ${BASE}/php/code/*.php ${BASE}/web/code/

docker build -t ebs-mysql ${BASE}/mysql
docker service update --force ebs_mysql
