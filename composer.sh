#!/bin/bash
#echo $1
docker run --rm -u 1000 --interactive --tty --volume $PWD:/app --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp composer $1
