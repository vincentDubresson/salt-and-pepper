#!/bin/bash

sudo rm -rf var/cache/

php bin/console c:cl && php bin/console c:w