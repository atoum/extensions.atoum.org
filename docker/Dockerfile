FROM php:7.4

RUN apt-get update && apt-get install -y wget zip

ARG uid=1008
RUN useradd -u ${uid} -m -s /bin/bash localUser

