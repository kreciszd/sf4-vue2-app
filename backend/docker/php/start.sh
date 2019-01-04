#!/bin/bash

printenv | sed 's/^\(.*\)\=\(.*\)$/export \1\="\2"/g' > /opt/start.sh
cron && tail -f /var/log/cron.log