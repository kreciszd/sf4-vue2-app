#!/bin/sh

trap 'kill -TERM $PID' TERM INT
nginx -g "daemon off;" &
PID=$!
wait $PID
trap - TERM INT
wait $PID
EXIT_STATUS=$?

exit $EXIT_STATUS