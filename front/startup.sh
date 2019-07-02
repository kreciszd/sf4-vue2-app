#!/bin/bash

# Automatyczne uruchomienie aplikacji
npm install && npm run serve --host 0.0.0.0 --disable-host-check

# UWAGA ! Tylko w srodowisku developerskim lokalnym ! Niepotrzebne na produkcji:
# Uruchomienie proxy portu 80 -> 8080 w celu umozliwienia komunikacji miedzymodulowej w srodowisku lokalnym
#socat TCP-LISTEN:80,fork TCP:127.0.0.1:8080 &

node

if [ "$SERVE_FRONT" == true ]
then
    npm install && npm run serve --host 0.0.0.0 --disable-host-check
fi

socat TCP-LISTEN:80,fork TCP:127.0.0.1:8080 &

node
