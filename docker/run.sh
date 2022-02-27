#!/bin/bash -ex
cd docker
docker build --build-arg uid=$UID -t atoum-extensions .
docker run -ti --user $UID -v $PWD/../:/app -w /app atoum-extensions /bin/bash
